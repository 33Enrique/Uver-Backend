<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function sendVerificationCode(Request $request)
{
    $request->validate([
        'numero_telefonico' => 'required|exists:users,numero_telefonico',
    ]);

    $user = User::where('numero_telefonico', $request->numero_telefonico)->first();

    $verificationCode = rand(100000, 999999);

    session(['verification_code' => $verificationCode]);
    session(['numero_telefonico' => $request->numero_telefonico]);

    $phoneNumber = '+506' . substr($request->numero_telefonico, -8);

    $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    $twilio->messages->create($phoneNumber, [
        'from' => env('TWILIO_PHONE_NUMBER'),
        'body' => "Tu código de verificación es: $verificationCode"
    ]);

    return redirect()->route('auth.verify')->with('success', 'El código de verificación ha sido enviado.');
}

    public function showVerificationForm()
    {
        return view('auth.verify');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|numeric',
        ]);

        $storedCode = session('verification_code');
        $numeroTelefonico = session('numero_telefonico');

        if ($request->verification_code == $storedCode) {
            session()->forget(['verification_code', 'numero_telefonico']);

            $user = User::where('numero_telefonico', $numeroTelefonico)->first();
            auth()->login($user);

            return redirect()->route('home')->with('success', 'Inicio de sesión exitoso.');
        } else {
            return redirect()->route('auth.verify')->with('error', 'Código de verificación incorrecto.');
        }
    }
};