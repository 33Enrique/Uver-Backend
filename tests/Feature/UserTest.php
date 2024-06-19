<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user_via_form()
    {
        $response = $this->post(route('users.store'), [
            'cedula' => '1234567890',
            'nombre' => 'John',
            'apellido1' => 'Doe',
            'apellido2' => 'Smith',
            'numero_telefonico' => '87654321',
        ]);

        $response->assertRedirect(route('users.create'));
        $this->assertDatabaseHas('users', [
            'cedula' => '1234567890',
            'nombre' => 'John',
            'apellido1' => 'Doe',
            'apellido2' => 'Smith',
            'numero_telefonico' => '87654321',
        ]);
    }

    /** @test */
    public function it_validates_required_fields_on_user_creation()
    {
        $response = $this->post(route('users.store'), []);

        $response->assertSessionHasErrors(['cedula', 'nombre', 'apellido1', 'apellido2', 'numero_telefonico']);
    }
};