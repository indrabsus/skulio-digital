<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table td {
            padding: 5px;
            border: none;
            border-bottom: 1px solid #000;
        }

        .text-right {
            text-align: right;
        }
    </style>
    <title>Struk Pembayaran PPDB</title>
</head>
<body>
    <div class="test">
        <div class="test">{{ $set->nama_instansi }}</div>
        <span class="test">Struk Pembayaran PPDB</span>
    </div>
    <table class="table table-sm mt-3">
        @php
            $total = App\Models\LogPpdb::where('id_siswa', $data->id_siswa)->where('jenis','p')->sum('nominal');
        @endphp
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
            <td>{{ $data->jenis == 'p' ? 'PPDB' : 'Pendaftaran' }} - {{ substr($data->no_invoice, 2, 3) == 'TRF' ? 'Transfer' : 'Cash' }}</td>
        </tr>
        <tr>
            <td>Catatan</td>
            <td>:</td>
            <td>@if ($total == 2350000)
                Tuntas
            @else
                Sisa Rp.{{ number_format(2350000 - $total,0,',','.') }}
            @endif</td>
        </tr>
    </table>
    <p class="text-right">Cimahi, {{ date('d M Y', strtotime($data->created_at))}}</p>
    <p class="text-right"><img src="{{ asset('template') }}/assets/img/qr.png" width="50px"> Panitia PPDB</p>
</body>
</html>
