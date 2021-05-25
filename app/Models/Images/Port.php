<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    /**
     * Variable used to declare model's 'fillable' variables
     *
     * @var $fillable
     */
    protected $fillable = [
        'host_port',
        'container_port',
    ];

    /**
     * The docker image relationship
     *
     * @return BelongsTo
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Return this as a docker image to satisfy DockerImageDescendant interface
     *
     * @return DockerImage
     */
    public function getImageAttribute(): DockerImage
    {
        return $this->image;
    }
}
