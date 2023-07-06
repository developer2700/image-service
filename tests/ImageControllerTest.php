<?php

namespace Tests;

use App\Controllers\ImageController;
use App\Services\ImageModifierService;
use PHPUnit\Framework\TestCase;
use App\ImageModifiers\CropModifier;
use App\ImageModifiers\ResizeModifier;

class ImageControllerTest extends TestCase
{
    protected $imageModifierService;

    protected function setUp(): void
    {
        $this->imageModifierService = new ImageModifierService(__DIR__ . '/../storage');
    }

    public function testGenerateImage(): void
    {   
        $modifiers[] = new CropModifier(200, 200);
        $imageController = new ImageController($this->imageModifierService);
        $generatedImageName = $imageController->generateImage('dog.jpg', $modifiers);

        // Assert that the generated image name is not empty or null
        $this->assertNotEmpty($generatedImageName);
        $this->assertNotNull($generatedImageName);
    }

    public function testCropImage(): void
    {
        $modifiers[] = new CropModifier(200, 200);
        $imageController = new ImageController($this->imageModifierService);
        $generatedImageName = $imageController->generateImage('dog.jpg', $modifiers);
        $fullFileName = $this->imageModifierService->getStoragePath().'/'.$generatedImageName;
        $generatedImageSize = getimagesize($fullFileName);

        // Verify the image dimensions
        $expectedWidth = 200;
        $expectedHeight = 200;
        $this->assertEquals($expectedWidth, $generatedImageSize[0]);
        $this->assertEquals($expectedHeight, $generatedImageSize[1]);
    }

    public function testResizeImage(): void
    {
        $modifiers[] = new CropModifier(300, 300);
        $imageController = new ImageController($this->imageModifierService);
        $generatedImageName = $imageController->generateImage('dog.jpg', $modifiers);
        $fullFileName = $this->imageModifierService->getStoragePath().'/'.$generatedImageName;
        $generatedImageSize = getimagesize($fullFileName);

        // Verify the image dimensions
        $expectedWidth = 300;
        $expectedHeight = 300;
        $this->assertEquals($expectedWidth, $generatedImageSize[0]);
        $this->assertEquals($expectedHeight, $generatedImageSize[1]);
    }
         
    public function testImageNotFound(): void
    {
        $nonExistingFilename = 'non-existing-image.jpg';
        $modifiers = [new CropModifier(200, 200)];
        $imageController = new ImageController($this->imageModifierService);
        // Assert that trying to generate an image with a non-existing filename throws an exception
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('HTTP/1.0 404 Not Found');

        $imageController->generateImage($nonExistingFilename, $modifiers);
    }
}
