<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class imageHelper
{
    private static function cropAndSaveImage($file, $folder, $width, $height, $prefix = 'image')
    {
        try {
            // Validasi file
            if (! $file || ! $file->isValid()) {
                throw new Exception('File upload tidak valid');
            }

            $extension = strtolower($file->getClientOriginalExtension());
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (! in_array($extension, $allowedExtensions)) {
                throw new Exception('Ekstensi file tidak didukung');
            }

            if (! Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }

            $filename = Str::uuid() . '_' . time() . '.' . $extension;
            $storagePath = "$folder/$filename";

            $image = null;
            switch ($extension) {
                case 'jpeg':
                case 'jpg':
                    $image = imagecreatefromjpeg($file->getRealPath());
                    break;
                case 'png':
                    $image = imagecreatefrompng($file->getRealPath());
                    break;
                case 'webp':
                    $image = imagecreatefromwebp($file->getRealPath());
                    break;
                default:
                    throw new Exception('Tipe gambar tidak didukung');
            }

            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);

            $aspectRatioOriginal = $originalWidth / $originalHeight;
            $aspectRatioTarget = $width / $height;

            if ($aspectRatioOriginal >= $aspectRatioTarget) {
                $newHeight = $originalHeight;
                $newWidth = (int) ($originalHeight * $aspectRatioTarget);
                $srcX = (int) (($originalWidth - $newWidth) / 2);
                $srcY = 0;
            } else {
                $newWidth = $originalWidth;
                $newHeight = (int) ($originalWidth / $aspectRatioTarget);
                $srcX = 0;
                $srcY = (int) (($originalHeight - $newHeight) / 3);
            }

            $imageCropped = imagecreatetruecolor($width, $height);

            if (in_array($extension, ['png', 'webp'])) {
                imagealphablending($imageCropped, false);
                imagesavealpha($imageCropped, true);
                $transparent = imagecolorallocatealpha($imageCropped, 0, 0, 0, 127);
                imagefill($imageCropped, 0, 0, $transparent);
            }

            if ($extension === 'jpeg' || $extension === 'jpg') {
                $exif = @exif_read_data($file->getRealPath());
                if ($exif !== false) {
                }
            }

            imagecopyresampled(
                $imageCropped,
                $image,
                0,
                0,
                $srcX,
                $srcY,
                $width,
                $height,
                $newWidth,
                $newHeight
            );

            if (function_exists('imageconvolution')) {
                $sharpenMatrix = [
                    [-1, -1, -1],
                    [-1, 24, -1],
                    [-1, -1, -1],
                ];
                $divisor = 16;
                $offset = 0;

                imageconvolution($imageCropped, $sharpenMatrix, $divisor, $offset);
            }

            $tempPath = tempnam(sys_get_temp_dir(), 'img');

            switch ($extension) {
                case 'jpeg':
                case 'jpg':
                    imagejpeg($imageCropped, $tempPath, 95);
                    break;
                case 'png':
                    imagepng($imageCropped, $tempPath, 9);
                    break;
                case 'webp':
                    imagewebp($imageCropped, $tempPath, 95);
                    break;
            }

            $success = Storage::disk('public')->put($storagePath, file_get_contents($tempPath));

            // Bersihkan
            unlink($tempPath);
            imagedestroy($image);
            imagedestroy($imageCropped);

            if (! $success) {
                throw new Exception('Gagal menyimpan gambar ke storage');
            }

            return $storagePath;
        } catch (Exception $e) {
            report($e);

            return null;
        }
    }

    public static function cropLogo($file, $folder = 'default', $width = 250, $height = 250)
    {
        return self::cropAndSaveImage($file, $folder, $width, $height, 'logo');
    }

    public static function cropIconImage($file, $folder = 'default', $width = 250, $height = 250)
    {
        return self::cropAndSaveImage($file, $folder, $width, $height, 'icons');
    }

    public static function cropArticleImage($file, $folder = 'default', $width = 1536, $height = 1024)
    {
        return self::cropAndSaveImage($file, $folder, $width, $height, 'articles');
    }

    public static function cropHeaderImage($file, $folder = 'default', $width = 800, $height = 600)
    {
        return self::cropAndSaveImage($file, $folder, $width, $height, 'headers');
    }

    public static function cropUserFoto($file, $folder = 'default', $width = 250, $height = 250)
    {
        return self::cropAndSaveImage($file, $folder, $width, $height, 'user');
    }

    public static function cropStafFoto($file, $folder = 'default', $width = 250, $height = 250)
    {
        return self::cropAndSaveImage($file, $folder, $width, $height, 'staf');
    }

    public static function cropPaymentMethodLogo($file, $folder = 'default', $width = 267, $height = 87)
    {
        return self::cropAndSaveImage($file, $folder, $width, $height, 'payment_logos');
    }
}
