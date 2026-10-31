<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Masuk | MBG Komunitas</title>
</head>
<body>
    <main>
        <a href="{{ auth()->user()->isPemantau() ? route('area.pemantau') : route('area.koordinator') }}">Kembali ke dasbor</a>
        <h1>Laporan Masuk</h1>

        @forelse ($reports as $report)
            <article>
                <h2>{{ $report->school->name }}</h2>
                <p>Pelapor: {{ $report->reporter->name }}</p>
                <p>Status: {{ ucfirst($report->status) }}</p>
                <small>{{ $report->created_at->format('d-m-Y H:i') }}</small>
                <p><a href="{{ route('reports.show', $report) }}">Lihat detail laporan</a></p>
            </article>
        @empty
            <p>Belum ada laporan masuk.</p>
        @endforelse

        {{ $reports->links() }}
    </main>
</body>
</html>
