<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Channel;
use Illuminate\Support\Str;
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
        $title=$this->faker->sentence(3);
        return [
           'title'=>$title,
           'desc'=>$this->faker->sentence(),
           'user_id'=>User::factory()->create()->id,
           'channel_id'=>Channel::factory()->create()->id,
           'slug'=>Str::slug($title),
           'lock'=>false
        ];
    }
}
