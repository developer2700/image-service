<?php

namespace App\Controllers;

use App\Services\ImageModifierService;

class ImageController
{
    private ImageModifierService $imageModifierService;

    public function __construct(ImageModifierService $imageModifierService)
    {
        $this->imageModifierService = $imageModifierService;
    }

    public function generateImage(string $filename, array $modifiers = []): string
    {
        try {
            $filePath = $this->imageModifierService->getStoragePath() .'/'. $filename;
            if (!file_exists($filePath)) {
                throw new \Exception('HTTP/1.0 404 Not Found');
                exit;
            }
            return $this->imageModifierService->getImage($filename, $modifiers); 
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function displayImage(string $generatedImageName): void
    {
        try {
            $redirectUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/diplayImage.php?image=' . $generatedImageName;
            header('Location: ' . $redirectUrl);
            exit;
            $fullFileName = $this->imageModifierService->getStoragePath() . '/' . $generatedImageName;
            $contentType = mime_content_type($fullFileName);
            header("Content-Type: $contentType");
            readfile($fullFileName);
            exit;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
