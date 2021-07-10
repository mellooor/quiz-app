<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\QuizTopic;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'topic' => $this->faker->text(12),
        ];
    }
}
