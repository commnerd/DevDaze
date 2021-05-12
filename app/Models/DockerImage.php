<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class DockerImage extends Model
{
    use HasFactory;

    protected $with = [
        "app",
    ];

    public function app(): BelongsTo
    {
        return $this->hasMany(App::class);
    }
}
