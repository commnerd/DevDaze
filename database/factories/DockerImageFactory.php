<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DockerImage;
use App\Models\App;

class DockerImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DockerImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $label = $this->faker->words(rand(1, 3), true);
        return [
            "app_id" => App::factory()->create(["title" => "App for \"$label\" docker image"])->id,
            "label" => $label,
            "tag" => $this->faker->word().":latest",
        ];
    }
}
