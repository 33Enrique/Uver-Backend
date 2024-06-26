<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerificationCode;
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

        VerificationCode::create([
            'numero_telefonico' => $request->numero_telefonico,
            'code' => $verificationCode,
        ]);

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

        $verificationRecord = VerificationCode::where('code', $request->verification_code)->latest()->first();

        if (!$verificationRecord) {
            return response()->json(['error' => 'Código de verificación incorrecto.'], 401);
        }

        $user = User::where('numero_telefonico', $verificationRecord->numero_telefonico)->first();
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }

        auth()->login($user);
        $verificationRecord->delete();

        return response()->json(['message' => 'Inicio de sesión exitoso.'], 200);
    }
};