<?php


namespace App\Http\Helpers;


class MimeExtensionHelper
{

    public static function fromMime($mime) :string
    {
        $mimes = [
            'jpeg' => [
                'image/jpeg',
                'image/x-citrix-jpeg',
                'image/pjpeg'
            ],
            'png' => [
                'image/png',
                'image/x-citrix-png',
                'image/x-png'
            ],
            'bmp' => [
                'image/bmp'
            ],
            'ico' => [
                'image/x-icon'
            ],
            'pcx' => [
                'image/x-pcx'
            ],
            'pic' => [
                'image/x-pict'
            ],
            'svg' => [
                'image/svg+xml'
            ],
            'rgb' => [
                'image/x-rgb'
            ],
            'tiff' => [
                'image/tiff'
            ],
            'webp' => [
                'image/webp'
            ]
        ];

        foreach ($mimes as $key => $value) {
            if (in_array($mime, $value, true)) {
                return $key;
            }
        }
        \Log::notice('File type wasn\'t found for mime ' . $mime);
        return 'undefined';
    }

}
