<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Group extends Model
{
    use HasFactory, Sluggable;

    public function validations() {
        return [
            'title' => 'required',
            'url' => 'required',
            'fs_path' => 'required',
        ];
    }

    protected $with = [
        "docker_images",
    ];

    protected $fillable = [
        "title",
        "url",
        "fs_path",
    ];

    public function docker_images(): HasMany
    {
        return $this->hasMany(DockerImage::class);
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
                'source' => 'title'
            ]
        ];
    }
}
