<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Interfaces\DockerImageDescendant;
use App\Models\DockerImages\Volume;
use App\Traits\BumpsService;

class DockerImage extends Model implements DockerImageDescendant
{
    use HasFactory, Sluggable, BumpsService;

    public function validations() {
        return [
            'app_id' => 'required',
            'label' => 'required',
            'tag' => 'required',
        ];
    }

    protected $fillable = [
        "app_id",
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
        return $this->app->slug."_".$this->slug;
    }

    /**
     * The app relationship
     *
     * @return BelongsTo
     */
    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class);
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
     * @return DockerImage
     */
    public function getDockerImage(): DockerImage {
        return $this;
    }
}
