<?php

namespace App\Validation;

class FilenameValidator
{
    private static $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    public static function validate(string $filename , string $storagePath): void
    {
        self::validateExtension($filename);
        self::validateImage($storagePath.'/'.$filename);
    }

    private static function validateExtension(string $filename): void
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array(strtolower($extension), self::$allowedExtensions)) {
            throw new \InvalidArgumentException('Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.');
        }
    }

    private static function validateImage(string $filename): void
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new \InvalidArgumentException('Invalid image file.');
        }

        $imageInfo = getimagesize($filename);

        if (!$imageInfo || !in_array($imageInfo[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF])) {
            throw new \InvalidArgumentException('Invalid image file. Only JPG, JPEG, PNG, and GIF images are allowed.');
        }
    }
}
