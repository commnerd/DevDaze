<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Interfaces\DockerImageDescendant;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BumpsService;
use App\Models\Image;

class Volume extends Model
{
    use HasFactory, BumpsService;

    /**
     * Variable used to declare model's 'fillable' variables
     *
     * @var $fillable
     */
    protected $fillable = [
        'host_path',
        'container_path',
    ];

    /**
     * The docker image relationship
     *
     * @return BelongsTo
     */
    public function docker_image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Return this as a docker image to satisfy DockerImageDescendant interface
     *
     * @return Image
     */
    public function getDockerImageAttribute(): Image
    {
        return $this->docker_image;
    }
}
