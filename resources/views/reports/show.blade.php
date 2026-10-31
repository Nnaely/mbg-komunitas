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

        @if (session('status'))
            <p role="status">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <ul role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

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

        <form method="POST" action="{{ route('reports.update', $report) }}">
            @csrf
            @method('PATCH')
            <label for="status">Perbarui status</label>
            <select id="status" name="status" required>
                @foreach (['baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $report->status) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit">Simpan status</button>
        </form>
    </main>
</body>
</html>
