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
    <title>Kelas {{ $full }}</title>
</head>
<body>

        <div class="containerr">
            <div class="test">
                <div class="test">SMK Sangkuriang 1 Cimahi</div>
                <div>Kelas {{ $full }}</div>
            </div>
            <table class="table table-bordered mt-3">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Username</th>
                </tr>
                <?php $no=1; ?>
                @foreach ($data as $d)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$d->nama_lengkap}}</td>
                    <td>{{$d->jenkel == 'l' ? 'Laki-laki' : 'Perempuan'}}</td>
                    <td>{{$d->username}}</td>
                </tr>
                @endforeach
            </table>


        </div>

</body>
</html>
