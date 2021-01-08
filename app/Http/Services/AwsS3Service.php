<?php

namespace App\Http\Services;

use Aws\S3\S3Client;

class AwsS3Service
{
    protected $client;

    public function __construct()
    {
        $config = [
            'region' => config('aws.region'),
            'version' => config('aws.version')
        ];

        $this->client = new S3Client($config);
    }

    public function client() {
        return $this->client;
    }
}
