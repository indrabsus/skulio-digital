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
    <title>Rekap Agenda Guru</title>
</head>
<body>

        <div>
            <div class="test">
                <span class="test">Rekap Agenda Guru</span>
                <p class="test">{{ date('F Y', strtotime($date)) }}</p>
            </div>
            <table class="table table-bordered mt-3 table-sm">
                <tr>
                    <th>No</th>
                    <th>Materi</th>
                    <th>Guru</th>
                    <th>Mapel</th>
                    <th>Kelas</th>
                    <th>Tahun/Semester</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
                <?php $no=1; ?>
                @foreach ($data as $d)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$d->materi}}</td>
                    <td>{{ $d->nama_lengkap }}</td>
                    <td>{{$d->nama_pelajaran}}</td>
                    <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                    <td>{{ $d->tingkatan }} {{ $d->tahun_pelajaran }}/{{ $d->semester }}</td>
                    <td>{{ date('d F Y', strtotime($d->created_at)) }}</td>

                      <td>
                        @if ($d->keterangan == 1)
                        Hadir
                        @elseif($d->keterangan == 2)
                        Tidak Hadir (Penugasan)
                        @elseif($d->keterangan == 3)
                        Tidak Hadir (Tanpa Keterangan)
                        @else
                        Belum dikonfirmasi
                        @endif
                      </td>
                </tr>
                @endforeach
            </table>

        </div>

</body>
</html>

