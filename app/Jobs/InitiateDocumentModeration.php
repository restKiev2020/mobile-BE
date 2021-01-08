<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InitiateDocumentModeration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $documents;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($documents)
    {
        $this->documents = collect($documents);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $documentsModels = Document::whereIn('url', $this->documents->pluck('url'))->get();

        if(count($documentsModels) > 0 ) {
            foreach ($documentsModels as $document) {
                $data = $this->documents->filter(static function ($doc) use ($document) {
                    return $doc['url'] === $document->url;
                });

                DetectImageNudity::dispatch($document, $data);
            }
        }
    }
}
