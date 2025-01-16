<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href={{ asset('template/assets/css/bootstrap.min.css') }}>
    <style>
        .test {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        .note {
            font-style: italic;
            float: left;
            font-size: 12px;
        }

        .table-bordered {
    border: 1px solid #333; /* Mengatur ketebalan dan warna border */
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #333; /* Mengatur ketebalan dan warna border pada sel tabel */
}

.table-bordered th {
    background-color: #f8f9fa; /* Warna latar belakang header tabel */
}

.table-bordered td {
    background-color: #fff; /* Warna latar belakang sel tabel */
}

.table-bordered tr {
    border-top: 1px solid #333; /* Mengatur ketebalan dan warna border atas setiap baris */
}

.table-bordered tr:first-child {
    border-top: none; /* Menghilangkan border atas pada baris pertama */
}
    </style>
    <title>Rekap SPP Bulanan</title>
</head>
<body>
    <div class="test">
        <span class="test">Rekap Bulanan SPP Siswa</span>
    <p class="test">Bulan {{ $bln.' '.$thn }}</p>
    </div>
    <table class="table table-bordered mt-3 table-sm">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Nominal</th>
            <th>Tanggal Bayar</th>
            <th>Keterangan</th>
        </tr>
        <?php $no=1; ?>
        @foreach ($data as $d)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$d->nama_lengkap}}</td>
            <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
            <td>Rp. {{number_format($d->nominal,0,',','.')}} ({{strtoupper($d->bayar)}})</td>
            <td>{{date('d F Y', strtotime($d->updated_at))}}</td>
            <td>{{$d->keterangan}}</td>
        </tr>
        @endforeach
    </table>

</body>
</html>

