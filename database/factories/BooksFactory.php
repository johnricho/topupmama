<?php

namespace Database\Factories;

use App\Models\Books;
use Illuminate\Database\Eloquent\Factories\Factory;

class BooksFactory extends Factory
{
    protected $model = Books::class;

    public function definition(): array
    {
    	return [
            'name' => $this->faker->name,
            'author' => $this->faker->name,
            'title' => $this->faker->name,
            'content' => $this->faker->paragraph,
    	];
    }
}
