<table class="table table-striped table-responsive-sm" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
    <tr>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word; width: 150px;">No</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word; width: 200px;">Nama Barang</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word; width: 200px;">Kegiatan</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Volume Pengajuan</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Harga Pengajuan</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Bulan Pengajuan</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Volume Realisasi</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Harga Realisasi</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Bulan Realisasi</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Total Realisasi</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Jenis</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Tahun Arkas</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Unit</th>
    </tr>
    <?php $no=1; ?>
    @foreach ($data as $d)
        <tr>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $no++ }}</td>
            <td style="border: 1px solid black; word-wrap: break-word; width: 200px;">{{ $d->nama_barang }}</td>
            <td style="border: 1px solid black; word-wrap: break-word; width: 200px;">{{ $d->nama_kegiatan }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->volume }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->perkiraan_harga }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->bulan_pengajuan }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->volume_realisasi }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->perkiraan_harga_realisasi }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->bulan_pengajuan_realisasi }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ number_format($d->perkiraan_harga_realisasi * $d->volume_realisasi,0,',','.') }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->jenis == 'ab' ? 'Barang Habis Pakai' : 'Barang Modal' }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->tahun_arkas }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->nama_role }}</td>
        </tr>
    @endforeach
</table>
