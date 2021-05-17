<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Group;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(rand(1, 3), true),
            'fs_path' => $this->getRandomDir(getenv("HOME"), rand(1, 3)),
            'url' => $this->faker->word(),
        ];
    }



    private function getRandomDir(string $basePath, int $depth = 1) {
        $dirs = glob($basePath . DIRECTORY_SEPARATOR . '*' , GLOB_ONLYDIR);

        if(sizeof($dirs) <= 0 && $depth === 0) {
            return $basePath;
        }

        return DIRECTORY_SEPARATOR . $dirs[rand(0, sizeof($dirs) - 1)];
    }
}
