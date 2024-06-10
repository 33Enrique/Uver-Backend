<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    
    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div>
            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" value="{{ old('cedula') }}">
            @error('cedula')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}">
            @error('nombre')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="apellido1">Primer apellido:</label>
            <input type="text" id="apellido1" name="apellido1" value="{{ old('apellido1') }}">
            @error('apellido1')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="apellido2">Segundo apellido:</label>
            <input type="text" id="apellido2" name="apellido2" value="{{ old('apellido2') }}">
            @error('apellido2')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="numero_telefonico">Número telefónico:</label>
            <input type="text" id="numero_telefonico" name="numero_telefonico" value="{{ old('numero_telefonico') }}">
            @error('numero_telefonico')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit">Registrarse</button>
        </div>
    </form>
</body>
</html>