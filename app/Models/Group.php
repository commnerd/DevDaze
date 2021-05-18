<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Jobs\ModifyNetwork;

class Group extends Model
{
    use HasFactory, Sluggable, DispatchesJobs;

    /**
     * Variable used to declare model's 'fillable' variables
     * 
     * @var $fillable
     */
    protected $fillable = [
        "title",
        "url",
        "fs_path",
    ];

    /**
     * Validation definitions
     * 
     * @return array Validation definitions
     */
    public function validations(): array {
        return [
            'title' => 'required',
            'url' => 'required',
            'fs_path' => 'required',
        ];
    }

    /**
     * Override save method to update configurations
     * 
     * @param array $options
     */
    public function save(array $options = []) {
        parent::save($options);

        $this->dispatch(new ModifyNetwork($this));
    }

    /**
     * Docker image relationship
     * 
     * @return HasMany
     */
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
