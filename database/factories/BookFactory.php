<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
    	return [
            'name' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'isbn' => $this->faker->isbn10(),
            'published_at' => Carbon::now()->subMonths(8),
    	];
    }
}
