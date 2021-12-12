<?php

namespace Database\Factories;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
    */
    public function definition()
    {
        return [
            'title'=>$this->faker->sentence(),
            'thread_id'=>Thread::factory()->create()->id,
        ];
    }
}
