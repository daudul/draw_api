<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileUpload
{
    const DISK_S3 = 's3';
    const DISK_LOCAL = 'local';
    const DISK_PUBLIC = 'public';

    public static function upload(object $file, string $diskName, string $folderName): array
    {
        $fileName = self::generateFileName(originalName: $file->getClientOriginalName(), slug: 'event');
        Storage::disk($diskName)->put($folderName.'/'.$fileName, file_get_contents($file));

        return [
            'file_name' => $folderName.'/'.$fileName,
            'disk' => $diskName
        ];
    }

    public static function getAllDisk(): array
    {
        return [
            self::DISK_S3, self::DISK_LOCAL
        ];
    }

    public static function generateFileName(string $originalName, ?string $slug = 'img'): string
    {
        return $slug.'_'.time().'_'.uniqid(). '.' . File::extension($originalName);
    }
}
