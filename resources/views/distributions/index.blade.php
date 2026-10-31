<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Distribusi Makanan | MBG Komunitas</title>
</head>
<body>
    <main>
        <h1>Daftar Distribusi Makanan</h1>
        <p>Jadwal menu simulasi untuk sekolah di Kota Bandung.</p>

        <table>
            <thead>
                <tr>
                    <th>Sekolah</th>
                    <th>Tanggal Distribusi</th>
                    <th>Keterangan Menu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($distributions as $item)
                    <tr>
                        <td>{{ $item->school->name }}</td>
                        <td>{{ $item->distribution_date->format('d-m-Y') }}</td>
                        <td>{{ $item->menu_description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada data distribusi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</body>
</html>
