<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dasbor {{ $namaPeran }} | MBG Komunitas</title>
</head>
<body>
    <main>
        <h1>Dasbor {{ $namaPeran }}</h1>
        <p>Selamat datang, {{ auth()->user()->name }}.</p>
        <p>Ini halaman awal untuk peran {{ strtolower($namaPeran) }}.</p>
        @if (auth()->user()->isPelapor())
            <p><a href="{{ route('reports.index') }}">Buat laporan</a></p>
        @endif
        @if (auth()->user()->isPemantau() || auth()->user()->isKoordinator())
            <p><a href="{{ route('distributions.index') }}">Lihat distribusi makanan</a></p>
            <p><a href="{{ route('reports.inbox') }}">Lihat laporan masuk</a></p>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </main>
</body>
</html>
