<?php

namespace Database\Factories;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsersFactory extends Factory
{
    protected $model = Users::class;

    public function definition(): array
    {
    	return [
            'fullname' => $this->faker->name,
            'email' => $this->faker->password,
            'password' => $this->faker->name,
            'username' => $this->faker->paragraph,
    	];
    }
}
