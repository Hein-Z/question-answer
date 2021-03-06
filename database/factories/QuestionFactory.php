<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>rtrim($this->faker->sentence(rand(5,10)),'.'),
            'body'=>$this->faker->paragraph(rand(3,5),true),
            'votes_count'=>rand(-3,3),
            'views'=>rand(4,6),
            'user_id' => User::pluck('id')->random()
        ];
    }
}
