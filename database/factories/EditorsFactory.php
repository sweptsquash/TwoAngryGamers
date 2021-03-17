<?php

namespace Database\Factories;

use App\Models\Editors;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EditorsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Editors::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->name(),
            'role_id'       => 3,
        ];
    }
}
