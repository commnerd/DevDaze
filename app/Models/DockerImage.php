<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\Sluggable;

class DockerImage extends Model
{
    use HasFactory, Sluggable;

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

    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class);
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
}
