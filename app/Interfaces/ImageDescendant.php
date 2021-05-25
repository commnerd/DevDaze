<?php

namespace App\Interfaces;

use App\Models\Image;

interface ImageDescendant {
    public function getImageAttribute(): Image;
}
