<?php

namespace App\ImageModifiers;

use Imagick;

class CropModifier implements ModifierInterface
{
    private int $width;
    private int $height;

    public function __construct(int $width, int $height)
    {
        if ($width <= 0 || $height <= 0) {
            throw new \Exception('Invalid crop dimensions.');
        }

        $this->width = $width;
        $this->height = $height;
    }

    public function modify(Imagick $image): void
    {
        $image->cropThumbnailImage($this->width, $this->height);
    }
}
