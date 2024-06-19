<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_user()
    {
        $user = User::factory()->create([
            'cedula' => '1234567890',
            'nombre' => 'John',
            'apellido1' => 'Doe',
            'apellido2' => 'Smith',
            'numero_telefonico' => '87654321',
        ]);

        $this->assertDatabaseHas('users', [
            'cedula' => '1234567890',
            'nombre' => 'John',
            'apellido1' => 'Doe',
            'apellido2' => 'Smith',
            'numero_telefonico' => '87654321',
        ]);
    }

    /** @test */
    public function it_fails_if_cedula_is_not_unique()
    {
        $user1 = User::factory()->create(['cedula' => '1234567890']);
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        $user2 = User::factory()->create(['cedula' => '1234567890']);
    }
};