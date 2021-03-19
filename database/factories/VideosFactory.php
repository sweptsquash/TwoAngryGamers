<?php

namespace Database\Factories;

use App\Models\Videos;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Videos::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'         => $this->faker->name(),
            'author'        => $this->faker->firstName(),
            'filename'      => 'example.mp4',
            'created'       => Carbon::now(),
            'thumbnail'     => 'example.jpg',
        ];
    }
}
