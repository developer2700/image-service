<?php

namespace App\Services;

use App\ImageModifiers\ModifierInterface;
use App\Utils\ImageInterface;
use App\Utils\ImagickImage;
use App\Validation\FilenameValidator;

class ImageModifierService
{
    public function __construct(
        private string $storagePath
    ) {}

    public function getImage(string $filename, array $modifiers = []): ?string
    {
        FilenameValidator::validate($filename , $this->storagePath);

        $image = $this->loadImage($filename);

        if ($image === null) {
            throw new \Exception('Image not found.');
        }

        $image->applyModifiers($modifiers);

        $generatedFilename = $this->generateFilename($filename);
        $image->save($this->storagePath . '/' . $generatedFilename);

        return $generatedFilename;
    }

    private function loadImage(string $filename): ?ImageInterface
    {
        $imagePath = $this->storagePath . '/' . $filename;

        if (!file_exists($imagePath)) {
            return null;
        }

        return new ImagickImage($imagePath);
    }

    private function generateFilename(string $filename): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);

        return $filenameWithoutExtension . '_' . time() . '.' . $extension;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }
}
