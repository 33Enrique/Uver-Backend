<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'cedula' => $this->faker->unique()->numerify('##########'),
            'nombre' => $this->faker->firstName,
            'apellido1' => $this->faker->lastName,
            'apellido2' => $this->faker->lastName,
            'numero_telefonico' => $this->faker->numerify('########'),
        ];
    }
};