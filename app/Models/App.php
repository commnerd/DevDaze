<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    protected $with = [
        "docker_images",
    ];

    protected $fillable = [
        "title",
        "url",
        "fs_path",
        "serve_exec",
    ];

    public function docker_images(): HasMany
    {
        return $this->hasMany(DockerImage::class);
    }
}
