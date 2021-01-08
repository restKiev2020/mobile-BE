<?php

namespace App\Jobs;

use App\Http\Services\ImageFilter;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DetectImageNudity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Document $document;

    private string $data;

    /**
     * Create a new job instance.
     *
     * @param Document $document
     * @param string $data
     */
    public function __construct(Document $document, string $data)
    {
        $this->document = $document;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param ImageFilter $imageFilter
     * @return void
     */
    public function handle(ImageFilter $imageFilter)
    {
        try {
            $bytes = random_bytes(5);
            $fileName = bin2hex($bytes);
            $storageTempPath = storage_path() . 'tmp' ;
            $tempFilePath = $storageTempPath . $fileName;
            if (!mkdir($storageTempPath, 0777, true) && !is_dir($storageTempPath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', 'path/to/directory'));
            }
            file_put_contents($tempFilePath, $this->data);

            $score = $imageFilter->GetScore($tempFilePath);

            if($score > 60) {
                $this->document->update([
                    'on_recognition' => false,
                    'is_nudity' => true
                ]);
            }

            $this->document->update([
                'on_recognition' => false,
            ]);
        }
        catch (\Throwable $exception) {
            \Log::error('Could not recognize image because' . $exception->getMessage() );
        }
    }
}
