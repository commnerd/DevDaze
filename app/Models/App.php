<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    protected $with = [
        "docker_images"
    ];

    public function dockerImages(): HasMany
    {
        return $this->hasMany(DockerImage::class);
    }
}
