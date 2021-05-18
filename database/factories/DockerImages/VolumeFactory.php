<?php

namespace Database\Factories\DockerImages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DockerImages\Volume;
use App\Models\DockerImage;

class VolumeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Volume::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'docker_image_id' => DockerImage::factory()->create(["title" => "Docker image for \"/tmp\" volume declaration"])->id,
            'host_path' => "/tmp",
            'container_path' => "/tmp",
        ];
    }
}
