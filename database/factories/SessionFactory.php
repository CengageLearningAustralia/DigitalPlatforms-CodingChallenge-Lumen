<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    protected $model = Session::class;

    public function definition(): array
    {
    	return [
            'name' => $this->faker->name,
            'user_id' => User::inRandomOrder()->value('id'),
            'start_at' => Carbon::now()->addDays(15),
    	];
    }
}
