<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    protected $model = Session::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words,
            'user_id' => User::inRandomOrder()->value('id'),
            'start_at' => Carbon::now()->addDays(15),
        ];
    }

    /**
     * Indicate that the dealer is active.
     *
     * @return Factory
     */
    public function inPast()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => Carbon::now()->subDays(15),
            ];
        });
    }
}
