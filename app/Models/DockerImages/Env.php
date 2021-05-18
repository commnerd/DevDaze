<?php

namespace App\Models\DockerImages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Interfaces\DockerImageDescendant;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BumpsService;
use App\Models\DockerImage;

class Env extends Model implements DockerImageDescendant
{
    use HasFactory, BumpsService;

    /**
     * The docker image relationship
     * 
     * @return BelongsTo
     */
    public function docker_image(): BelongsTo
    {
        return $this->belongsTo(DockerImage::class);
    }

    /**
     * Return this as a docker image to satisfy DockerImageDescendant interface
     * 
     * @return DockerImage
     */
    public function getDockerImageAttribute(): DockerImage
    {
        return $this->docker_image;
    }
}
