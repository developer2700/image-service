<?php

namespace App\Utils;

use Imagick;

class ImagickImage implements ImageInterface
{
    private Imagick $image;
    private int $width;
    private int $height;

    public function __construct(string $filename)
    {
        if (!file_exists($filename)) {
            throw new \Exception('Image not found.');
        }
       
        $this->image = new Imagick($filename);
        $this->width = $this->image->getImageWidth();
        $this->height = $this->image->getImageHeight();
    }

    public function applyModifiers(array $modifiers): void
    {
        foreach ($modifiers as $modifier) {
            $modifier->modify($this->image);
        }
    }

    public function save(string $filename): bool
    {
        return $this->image->writeImage($filename);
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}
