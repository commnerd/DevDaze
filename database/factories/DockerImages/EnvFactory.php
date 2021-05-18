<?php

namespace Database\Factories\DockerImages;

use App\Models\DockerImages\Env;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnvFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Env::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $env = strtoupper($this->faker->word());
        return [
            'docker_image_id' => DockerImage::factory()->create(["title" => "Docker image for \"$env\" port declaration"])->id,
            'label' => $env,
            'value' => $this->faker->word(),
        ];
    }
}
