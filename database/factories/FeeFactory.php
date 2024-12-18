<?php

namespace Database\Factories;

use App\Models\Fee;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeeFactory extends Factory
{
    protected $model = Fee::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(2, 0, 9999),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
