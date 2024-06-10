<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
</head>
<body>
    <h1>Inicio de Sesión</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    <form action="{{ route('auth.send_code') }}" method="POST">
        @csrf
        <div>
            <label for="numero_telefonico">Número Telefónico</label>
            <input type="text" id="numero_telefonico" name="numero_telefonico" value="{{ old('numero_telefonico') }}">
            @error('numero_telefonico')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit">Enviar Código de Verificación</button>
        </div>
    </form>
</body>
</html>