<?php

namespace Database\Factories;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->name(),
            'interval'      => 1,
            'start'         => Carbon::now(),
            'duration'      => 3600,
            'description'   => $this->faker->text(),
            'special'       => false,
        ];
    }
}
