<?php

namespace App\Http\Controllers\Api\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDocumentRequest;
use App\Http\Services\DocumentService;
use App\Models\Document;

class DocumentController extends Controller
{
    public function show(int $id)
    {
        /** @var Document $document*/
        $document = Document::find($id);

        if(!$document) {
            return response()->json('Document not found', 404);
        }

        return response()->json($document->append('data'), 200);
    }

    public function store(CreateDocumentRequest $request, DocumentService $documentService)
    {
        $documentRequest = $request->validated();
        $insertedDocuments = $documentService->uploadDocuments($documentRequest['documents']);

        if (count($insertedDocuments) > 0) {
            return response()->json('Failed to create documents', 400);
        }

        return response()->json('Created', 201);
    }

    public function byAdvert(int $id)
    {
        $documents = Document::where(['advert_id' => $id])->get();

        return response()->json($documents, 200);
    }

    public function destroy(int $id, DocumentService $documentService) {

        $document = Document::find($id);

        if(!$document) {
            return response()->json('Not found', 404);
        }

        $result = $documentService->destroyDocument($document);

        if(!$result) {
            return response()->json('Could not delete document', 404);
        }

        return response()->json('', 204 );
    }

}
