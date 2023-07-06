<?php

namespace App\ImageModifiers;

use Imagick;

class ResizeModifier implements ModifierInterface
{
    public function __construct(private int $width,private int $height)
    {
        if ($width <= 0 || $height <= 0) {
            throw new \Exception('Invalid resize dimensions.');
        } 
    }

    public function modify(Imagick $image): void
    {
        $image->resizeImage($this->width, $this->height, Imagick::FILTER_LANCZOS, 1, true);
    }
}
