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
    </style>
    <title>Rekap Tabungan Bulanan</title>
</head>
<body>
    <div class="test">
        <span class="test">Rekap Bulanan Tabungan Siswa</span>
    <p class="test">Bulan {{ $bln.' '.$thn }}</p>
    </div>
    <table class="table table-bordered mt-3">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jenis</th>
            <th>Nominal</th>
            <th>Log</th>
        </tr>
        <?php $no=1; ?>
        @foreach ($data as $d)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$d->nama_lengkap}}</td>
            <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
            <td>{{$d->jenis == 'kd' ? 'Menabung' : 'Tarik Tunai'}}</td>
            <td>Rp. {{number_format($d->nominal,0,',','.')}}</td>
            <td>{{$d->updated_at}}</td>
        </tr>
        @endforeach
    </table>
   
</body>
</html>

