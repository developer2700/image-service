<?php

namespace App\Utils;

interface ImageInterface
{
    public function applyModifiers(array $modifiers): void;
    public function save(string $filename): bool;
    public function getWidth(): int;
    public function getHeight(): int;
}
