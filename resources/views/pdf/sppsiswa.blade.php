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
    <title>Struk SPP Siswa</title>
</head>
<body>
    <div class="test">
        <span class="test">Struk SPP Siswa</span>
    </div>
    <div class="test">
        <span class="test">SMK Sangkuriang 1 Cimahi</span>
    </div>
    <table class="table table-sm mt-3">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>{{ $data->tingkat.' '.$data->singkatan.' '.$data->nama_kelas }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>Kelas {{ $data->keterangan }}</td>
        </tr>
        <tr>
            <td>Nominal</td>
            <td>:</td>
            <td>Rp.{{ number_format($data->nominal,0,',','.') }}</td>
        </tr>

        <tr>
            <td>Tanggal Bayar</td>
            <td>:</td>
            <td>{{ date('d F Y', strtotime($data->created_at)) }}</td>
        </tr>
    </table>
    <p class="note"><u>Note : <br> Cek Skulio untuk melihat saldo</u></p>
    <p class="text-right">Cimahi, {{ date('d M Y')}}</p>
    <br>
    <p class="text-right">Petugas</p>

</body>
</html>

