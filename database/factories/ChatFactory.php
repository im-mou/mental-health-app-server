<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = ['question', 'answer'];
        return [
            'journal_id' => $this->faker->numberBetween(1, 10),
            'type' => Arr::random($type),
            'body' => $this->faker->text(20),
        ];
    }

}
