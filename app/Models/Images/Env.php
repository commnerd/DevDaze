<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Interfaces\ImageDescendant;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BumpsService;
use App\Models\Image;

class Env extends Model implements ImageDescendant
{
    use HasFactory, BumpsService;

    /**
     * Variable used to declare model's 'fillable' variables
     *
     * @var $fillable
     */
    protected $fillable = [
        'label',
        'value',
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
     * @return Image
     */
    public function getImageAttribute(): Image
    {
        return $this->image;
    }
}
