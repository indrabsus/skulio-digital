<table class="table table-striped table-responsive-sm" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
    <tr>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">No</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Nama Barang</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Kegiatan</th>
        {{-- <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Volume Pengajuan</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Harga Pengajuan</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Bulan Pengajuan</th> --}}
        <th style="border: 1px solid black; background-color: #f0f0f0; word-wrap: break-word;">Harga Satuan</th>
        <th style="border: 1px solid black; background-color: #f0f0f0; word-wrap: break-word;">Volume Realisasi</th>
        <th style="border: 1px solid black; background-color: #f0f0f0; word-wrap: break-word;">Harga Realisasi</th>
        <th style="border: 1px solid black; background-color: #f0f0f0; word-wrap: break-word;">Bulan Realisasi</th>
        <th style="border: 1px solid black; background-color: #f0f0f0; word-wrap: break-word;">Total Realisasi</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Jenis</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Tahun Arkas</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Unit</th>
        <th style="border: 1px solid black; background-color: #d3d3d3; word-wrap: break-word;">Status</th>
    </tr>
    <?php $no=1; ?>
    @foreach ($data as $d)
        <tr style="background-color: #fffccc;">
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $no++ }}</td>
            <td style="border: 1px solid black; word-wrap: break-word; width: 200px;">{{ $d->nama_barang }}</td>
            <td style="border: 1px solid black; word-wrap: break-word; width: 200px;">{{ $d->nama_kegiatan }}</td>
            {{-- <td style="border: 1px solid black; background-color: #e0e0e0; word-wrap: break-word;">{{ $d->volume }}</td>
            <td style="border: 1px solid black; background-color: #e0e0e0; word-wrap: break-word;">{{ $d->perkiraan_harga }}</td>
            <td style="border: 1px solid black; background-color: #e0e0e0; word-wrap: break-word;">{{ $d->bulan_pengajuan }}</td> --}}
            <td style="border: 1px solid black; background-color: #f7f7f7; word-wrap: break-word;">@if ($d->jenis != "Jasa")
                {{ $d->perkiraan_harga_realisasi * $persen }}
            @else
            {{ $d->perkiraan_harga_realisasi }}
            @endif</td>
            <td style="border: 1px solid black; background-color: #f7f7f7; word-wrap: break-word;">{{ $d->volume_realisasi }}</td>
            <td style="border: 1px solid black; background-color: #f7f7f7; word-wrap: break-word;">{{ $d->perkiraan_harga_realisasi }}</td>
            <td style="border: 1px solid black; background-color: #f7f7f7; word-wrap: break-word;">{{ $d->bulan_pengajuan_realisasi }}</td>
            <td style="border: 1px solid black; background-color: #f7f7f7; word-wrap: break-word;">@if ($d->jenis != "Jasa")
                {{ $d->perkiraan_harga_realisasi * $d->volume_realisasi * $persen }}
            @else
            {{ $d->perkiraan_harga_realisasi * $d->volume_realisasi }}
            @endif</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->jenis == 'Jasa' ? 'Harga Tayang' : $d->jenis }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->tahun_arkas }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">{{ $d->nama_role }}</td>
            <td style="border: 1px solid black; word-wrap: break-word;">
                @if ($d->status == '1')
                    Disetujui
                @elseif($d->status == '2')
                    Realisasi
                @else
                    Ditolak
                @endif
            </td>
        </tr>
    @endforeach
</table>
