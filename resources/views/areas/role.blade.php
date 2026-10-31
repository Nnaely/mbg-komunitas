<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Area {{ $namaPeran }} | MBG Komunitas</title>
</head>
<body>
    <main>
        <h1>Area {{ $namaPeran }}</h1>
        <p>Selamat datang, {{ auth()->user()->name }}.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </main>
</body>
</html>
