<?php

namespace App\ImageModifiers;

use Imagick;

interface ModifierInterface
{
    public function modify(Imagick $image): void;
}
