<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href={{ asset('template/assets/css/bootstrap.min.css') }}>
    <style>
        .containerr {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
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
    <title>Kelas {{ $kelas->nama_kelas }}</title>
</head>
<body>

        <div class="containerr">
            <div class="test">
                <div class="test">SMK Sangkuriang 1 Cimahi</div>
                <div class="test">Jurusan {{ $kelas->nama_jurusan }}</div>
                <div>Kelas {{ $kelas->nama_kelas }}</div>
            </div>
            <table class="table table-bordered mt-3">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Asal Sekolah</th>
                    <th>Uang Masuk</th>
                </tr>
                <?php $no=1; ?>
                @foreach ($data as $d)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$d->nama_lengkap}}</td>
                    <td>{{$d->jenkel == 'l' ? 'Laki-laki' : 'Perempuan'}}</td>
                    <td>{{$d->asal_sekolah}}</td>
                    <td>@php
                        $log = App\Models\LogPpdb::where('id_siswa', $d->id_siswa)
                        ->where('jenis','p')
                        ->sum('nominal');
                    @endphp
                    Rp.{{ number_format($log,0,',','.') }}</td>
                </tr>
                @endforeach
            </table>
            <div>L : {{ $jumlahlaki }} Siswa</div>
            <div>P : {{ $jumlahperempuan }} Siswa</div>
            <div>Total : {{ $jumlahlaki + $jumlahperempuan }} Siswa</div>

        </div>

</body>
</html>
