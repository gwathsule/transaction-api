<?php

namespace Database\Factories;

use App\Domains\Store\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition()
    {
        return [
            'cnpj' => $this->faker->unique()->numerify('##############'),
        ];
    }
}
