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
    <title>Struk Pembayaran PPDB</title>
</head>
<body>
    <div class="test">
        <div class="test">{{ $set->nama_instansi }}</div>
        <span class="test">Struk Pembayaran PPDB</span>
    <p class="test">{{ $data->no_invoice }}</p>
    </div>
    <table class="table table-sm mt-3">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Asal Sekolah</td>
            <td>:</td>
            <td>{{ $data->asal_sekolah }}</td>
        </tr>
        <tr>
            <td>Nominal</td>
            <td>:</td>
            <td>Rp.{{ number_format($data->nominal,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>{{ $data->jenis == 'p' ? 'PPDB' : 'Pendaftaran' }}</td>
        </tr>
    </table>
    <p class="text-right">Cimahi, {{ date('d M Y', strtotime($data->created_at))}}</p>
    <br>
    <p class="text-right">.....................</p>

</body>
</html>

