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
    <title>Rekap Harian PPDB</title>
</head>
<body>

        <div class="containerr">
            <div class="test">
                <span class="test">Rekap Harian PPDB</span>
                <p class="test">{{ date('d F Y', strtotime($date)) }}</p>
            </div>
            <table class="table table-bordered mt-3">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Asal Sekolah</th>
                    <th>Daftar</th>
                    <th>PPDB</th>
                    <th>Pembayaran</th>
                </tr>
                <?php $no=1; ?>
                @foreach ($data as $d)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$d->nama_lengkap}}</td>
                    <td>{{$d->asal_sekolah}}</td>
                    <td>{{ $d->jenis == 'd' ? 'Rp.'.number_format($d->nominal,0,',','.') : '-' }}</td>
                    <td>{{ $d->jenis == 'p' ? 'Rp.'.number_format($d->nominal,0,',','.') : '-' }}</td>
                    <td>{{ substr($d->no_invoice, 2, 3) }}</td>
                </tr>
                @endforeach
            </table>
            <div class="test">
                <hr>
                <h5>Total Uang Pendaftaran : Rp. {{ number_format($daftar,0,',','.') }}</h5>
                <h5>Total Uang PPDB : Rp. {{ number_format($ppdb,0,',','.') }}</h5>
                <hr>
                <h5>Total Semua : Rp. {{ number_format($ppdb+$daftar,0,',','.') }}</h5>
            </div>

        </div>

</body>
</html>

