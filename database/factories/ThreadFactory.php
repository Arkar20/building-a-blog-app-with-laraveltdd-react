<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'title'=>$this->faker->word(),
           'desc'=>$this->faker->sentence(),
        ];
    }
}
