<?php

namespace App\Http\Services;

use App\Http\Helpers\MimeExtensionHelper;
use App\Models\Document;
use Aws\Exception\AwsException;
use Throwable;

class DocumentService
{
    private $client;

    public function __construct(AwsS3Service $awsS3Service)
    {
        $this->client = $awsS3Service->client();
    }

    public function uploadDocuments(array $documents): array
    {
        $documentsForInspection = [];
        foreach ($documents as $key => &$document) {
            $document = $this->prepareDocumentForSaving($document);
            $documentsForInspection[$key] = $document;

            try {
                $url = $this->saveDocumentToS3($document);
                $document['url'] = $url;
                $documentsForInspection[$key]['url'] = $url;

                unset($document['data'], $document['mime']);
            } catch (AwsException $exception) {
                unset($documents[$key], $documentsForInspection[$key]);
                \Log::error('Could not upload file because ' . $exception->getMessage());
            }
        }

        $inserted = Document::insertMany($documents);

        if(!$inserted) {
            return [];
        }

        return $documentsForInspection;
    }

    public function createDocument($document): Document
    {
        $document = $this->prepareDocumentForSaving($document);

        try {
            $url = $this->saveDocumentToS3($document);
            var_dump($url);
            $document['url'] = $url;
            unset($document['data'], $document['mime']);
        } catch (AwsException $exception) {
            \Log::error('Could not upload file because ' . $exception->getMessage());
        }

        return Document::create($document);
    }

    public function destroyDocument(Document $document): bool
    {
        try {
            $res = $this->client->deleteObject([
                'Bucket' => config('aws.bucket'),
                'Key' => $this->getAwsSavePath($document)
            ]);
        } catch (Throwable $exception) {
            \Log::error('Could not remove file because ' . $exception->getMessage());
        }

        return $document->delete();
    }

    private function prepareDocumentForSaving($document)
    {
        $document['data'] = base64_decode($document['data']);
        $document['file_type'] = MimeExtensionHelper::fromMime($document['mime']);
        $document['file_name'] = $this->deductFileName($document['file_type'], $document['file_name']);

        return $document;
    }

    private function saveDocumentToS3($document)
    {
        $result = $this->client->putObject([
            'Bucket' => config('aws.bucket'),
            'Key' => $this->getAwsSavePath($document),
            'Body' => $document['data'],
            'ContentType' => $document['mime'],
            'ACL' => 'public-read'
        ]);

        return $result->get('ObjectURL');
    }

    private function deductFileName(string $type, string $fileName): string
    {
        $nameParts = explode('.', $fileName);
        $final = $fileName;
        if (count($nameParts) === 1) {
            $final = $fileName . '.' . $type;
        }

        if ($this->isExistingDocumentName($final)) {
            $nameParts = explode('.', $final);
            $final = $nameParts[0] . '-' . bin2hex(random_bytes(4)) . '.' . $nameParts[1];
        }

        return $final;
    }

    private function isExistingDocumentName(string $documentName): bool
    {
        return Document::where(['file_name' => $documentName])->exists();
    }

    /**
     * @param Document|array $document
     * @return string
     */
    private function getAwsSavePath($document)
    {
        return 'documents/user-' . $document['user_id'] . '/' . $document['file_name'];
    }

}
