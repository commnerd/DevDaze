<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;
use App\Models\Group;

class DockerImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $label = $this->faker->words(rand(1, 3), true);
        return [
            "group_id" => Group::factory()->create(["title" => "Group for \"$label\" docker image"])->id,
            "label" => $label,
            "tag" => $this->faker->word().":latest",
        ];
    }
}
