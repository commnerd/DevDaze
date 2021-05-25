<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Interfaces\ImageDescendant;
use App\Models\Images\Volume;
use App\Traits\BumpsService;

class Image extends Model implements ImageDescendant
{
    use HasFactory, Sluggable, BumpsService;

    public function validations() {
        return [
            'group_id' => 'required',
            'label' => 'required',
            'tag' => 'required',
        ];
    }

    protected $fillable = [
        "group_id",
        "label",
        "tag",
    ];

    /**
     * Get image/container name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->group->slug."_".$this->slug;
    }

    /**
     * The group relationship
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(group::class);
    }

    /**
     * The volumes relationship
     *
     * @return HasMany
     */
    public function volumes(): HasMany
    {
        return $this->hasMany(Volume::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'label'
            ]
        ];
    }

    /**
     * Return this as a docker image to satisfy DockerImageDescendant interface
     *
     * @return Image
     */
    public function getDockerImageAttribute(): Image {
        return $this;
    }
}
