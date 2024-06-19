<table class="table table-bordered mt-3">
    <tr>
        <td>Jumlah Pendaftar Total</td><th>{{ $sudahdaftar }} Siswa</th>
    </tr>
    <tr>
        <td>Kuota Sekolah</td><th>432 Siswa</th>
    </tr>
    <tr>
        <td>Sisa</td><th>{{ 432 - $sudahdaftar }} Siswa</th>
    </tr>
</table>
<table class="table table-bordered mt-3">
    <tr>
        <th>Jurusan</th>
        <th>Kuota</th>
        <th>Terisi</th>
        <th>Sisa</th>
    </tr>

    <tr>
        <td>AKUNTASI</td><td>108 Siswa</td><td>{{ $ak }} Siswa</td><td>{{ 108 - $ak }} Siswa</td>
    </tr>
    <tr>
        <td>PPLG</td><td>108 Siswa</td><td>{{ $pplg }} Siswa</td><td>{{ 108 - $pplg }} Siswa</td>
    </tr>
    <tr>
        <td>Pemasaran</td><td>108 Siswa</td><td>{{ $pm }} Siswa</td><td>{{ 108 - $pm }} Siswa</td>
    </tr>
    <tr>
        <td>MPLB</td><td>108 Siswa</td><td>{{ $mplb }} Siswa</td><td>{{ 108 - $mplb }} Siswa</td>
    </tr>

</table>
