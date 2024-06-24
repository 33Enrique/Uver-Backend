<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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

        return response()->json(['message' => 'El código de verificación ha sido enviado.'], 200);
    }

    public function verifyCode(Request $request)
{
    $request->validate([
        'verification_code' => 'required|numeric',
    ]);

    $storedCode = session('verification_code');
    $numeroTelefonico = session('numero_telefonico');

    if (!$storedCode || !$numeroTelefonico) {
        return response()->json(['error' => 'No se encontró la sesión de verificación.'], 401);
    }

    if ($request->verification_code == $storedCode) {
        session()->forget(['verification_code', 'numero_telefonico']);

        $user = User::where('numero_telefonico', $numeroTelefonico)->first();
        auth()->login($user);

        return response()->json(['message' => 'Inicio de sesión exitoso.'], 200);
    } else {
        return response()->json(['error' => 'Código de verificación incorrecto.'], 401);
    }
}
};