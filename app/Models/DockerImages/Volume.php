<?php

namespace App\Models\DockerImages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Interfaces\DockerImageDescendant;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BumpsService;
use App\Models\DockerImage;

class Volume extends Model
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
    public function getDockerImage(): DockerImage
    {
        return $this->docker_image;
    }
}
