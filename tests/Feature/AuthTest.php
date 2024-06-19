<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_verification_code()
    {
        $user = User::factory()->create(['numero_telefonico' => '84414959']);

        $response = $this->post(route('auth.send_code'), ['numero_telefonico' => '84414959']);
        
        $response->assertRedirect(route('auth.verify'));
        $response->assertSessionHas('success', 'El código de verificación ha sido enviado.');
        $this->assertNotNull(session('verification_code'));
    }

    /** @test */
    public function it_fails_verification_with_wrong_code()
    {
        $user = User::factory()->create(['numero_telefonico' => '84414959']);
        
        Session::put('verification_code', '123456');
        Session::put('numero_telefonico', '84414959');

        $response = $this->post(route('auth.verify_code'), ['verification_code' => '000000']);
        
        $response->assertRedirect(route('auth.verify'));
        $response->assertSessionHas('error', 'Código de verificación incorrecto.');
    }
};