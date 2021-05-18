<?php

namespace Database\Factories\DockerImages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DockerImage\Port;

class PortFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Port::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'docker_image_id' => DockerImage::factory()->create(["title" => "Docker image for \"42\" port declaration"])->id,
            'host_port' => 42,
            'container_port' => 42,
        ];
    }
}
