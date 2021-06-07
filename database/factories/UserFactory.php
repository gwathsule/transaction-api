<?php

namespace Database\Factories;

use App\Domains\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'isStore' => false,
            'name' => $this->faker->name,
            'cpf' => $this->faker->unique()->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail,
            'balance' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
