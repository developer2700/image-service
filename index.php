<?php

use App\Controllers\ImageController;
use App\Services\ImageModifierService;
use App\ImageModifiers\CropModifier;
use App\ImageModifiers\ResizeModifier;

require __DIR__ . '/vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];
// Check if a request URL is present
if (strlen($requestUri) > 1) {
    // Instantiate the ImageController and ImageModifierService
    $storagePath = __DIR__ . '/storage';
    $imageModifierService = new ImageModifierService($storagePath);
    $imageController = new ImageController($imageModifierService);

    // Example usage: http://localhost:8080/dog.jpg/crop-200-200
    $requestParts = explode('/', ltrim($requestUri, '/'));

    // Remove empty parts and extract the filename
    $requestParts = array_filter($requestParts);
    $filename = array_shift($requestParts);
 
    // Process the modifiers
    $modifiers = [];
    foreach ($requestParts as $part) {
        $modifierParts = explode('-', $part);

        if (count($modifierParts) >= 3 && $modifierParts[0] === 'crop') {
            $width = (int) $modifierParts[1];
            $height = (int) $modifierParts[2];
            $modifiers[] = new CropModifier($width, $height);
        }

        if (count($modifierParts) >= 3 && $modifierParts[0] === 'resize') {
            $width = (int) $modifierParts[1];
            $height = (int) $modifierParts[2];
            $modifiers[] = new ResizeModifier($width, $height);
        }
    }
    try {
        if(count($modifiers)) {
            $generatedImageName = $imageController->generateImage($filename, $modifiers);
            $imageController->displayImage($generatedImageName);
        }
    } catch (\Exception $e) {
        // Log the error, display a user-friendly error page, or handle the exception as needed
        // For now, let's just throw it again
        throw $e;
    }
} else {
    // Handle the case when no request URL is present
    // Display a default page, show an error message, or redirect to another page
    // For now, let's echo a simple message
    echo 'Please provide an Url for crop or resize ex http://localhost:8080/dog.jpg/crop-200-200.';
}
