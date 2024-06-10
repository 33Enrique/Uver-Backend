<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'cedula' => $this->faker->unique()->numerify('##########'),
            'nombre' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'numero_telefonico' => $this->faker->phoneNumber,
        ];
    }
};