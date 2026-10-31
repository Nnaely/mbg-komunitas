<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Laporan | MBG Komunitas</title>
</head>
<body>
    <main>
        <a href="{{ route('reports.inbox') }}">Kembali ke laporan masuk</a>
        <h1>Detail Laporan</h1>

        <dl>
            <dt>Sekolah</dt>
            <dd>{{ $report->school->name }}</dd>

            <dt>Pelapor</dt>
            <dd>{{ $report->reporter->name }}</dd>

            <dt>Waktu laporan</dt>
            <dd>{{ $report->created_at->format('d-m-Y H:i') }}</dd>

            <dt>Status</dt>
            <dd>{{ ucfirst($report->status) }}</dd>

            <dt>Isi laporan</dt>
            <dd>{{ $report->description }}</dd>
        </dl>
    </main>
</body>
</html>
