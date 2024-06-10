<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cedula' => 'required|unique:users,cedula',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'numero_telefonico' => 'required|string|max:15',
        ]);

        User::create($request->only(['cedula', 'nombre', 'apellidos', 'numero_telefonico']));

        return redirect()->route('users.create')->with('success', 'Usuario registrado exitosamente.');
    }
};