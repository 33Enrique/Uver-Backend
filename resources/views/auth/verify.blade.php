<!DOCTYPE html>
<html>
<head>
    <title>Verificación de Código</title>
</head>
<body>
    <h1>Verificación de Código</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    <form action="{{ route('auth.verify_code') }}" method="POST">
        @csrf
        <div>
            <label for="verification_code">Código de Verificación</label>
            <input type="text" id="verification_code" name="verification_code" value="{{ old('verification_code') }}">
            @error('verification_code')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit">Verificar Código</button>
        </div>
    </form>
</body>
</html>