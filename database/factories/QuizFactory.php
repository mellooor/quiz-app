<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\QuizTopic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quiz::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => User::all()->first->id,
            'topic_id' => QuizTopic::all()->first->id,
            'title' => $this->faker->text(12)
        ];
    }
}
