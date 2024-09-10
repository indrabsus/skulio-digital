<div>
    <div class="row">

        <div class="container">
            @if (session('sukses'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h5>Sukses!</h5>
                    {{ session('sukses') }}
                </div>
            @endif
            @if (session('gagal'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h5>Gagal!</h5>
                    {{ session('gagal') }}
                </div>
            @endif
        </div>
        <div class="col">
            <div class="row justify-content-between mt-2">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary btn-xs mb-3" wire:click="showKolom()">
                        Tampilkan pengajuan
                    </button>
                </div>
                <div class="col-lg-3">
                    <div class="input-group input-group-sm mb-3">
                        <div class="col-3">
                            <select class="form-control" wire:model.live="result">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <input type="text" class="form-control" placeholder="Cari..." aria-label="Username"
                            aria-describedby="basic-addon1" wire:model.live="cari">
                        <span class="input-group-text" id="basic-addon1">Cari</span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kegiatan</th>
                            @if ($show)
                            <th class="bg-warning">Jumlah Pengajuan</th>
                            <th class="bg-warning">Bulan Pengajuan</th>
                            <th class="bg-warning">Harga Pengajuan</th>
                            @endif
                            <th>Jumlah Realisasi</th>
                            <th>Bulan Realisasi</th>
                            <th>Harga Realisasi</th>
                            <th>Total</th>
                            <th>Jenis</th>
                            <th>Tahun Arkas</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Distribusi</th>
                            <th>Sisa</th>
                            @if (Auth::user()->id_role == 1 || Auth::user()->id_role == 16 || auth()->user()->id_role == 3)
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                                <td>{{ $d->nama_barang }}</td>
                                <td>{{ $d->nama_kegiatan }}</td>
                                @if ($show)
                                <td class="bg-primary">{{ $d->volume }} {{ $d->satuan }}</td>
                                <td class="bg-primary">{{ $d->bulan_pengajuan }}</td>
                                <td class="bg-primary">Rp.{{ number_format($d->perkiraan_harga,0,',','.') }}</td>
                                @endif
                                <td>{{ $d->volume_realisasi }} {{ $d->satuan }}</td>
                                <td>{{ $d->bulan_pengajuan_realisasi }}</td>
                                <td>Rp.{{ number_format($d->perkiraan_harga_realisasi,0,',','.') }}</td>
                                <td>Rp.{{ number_format($d->perkiraan_harga_realisasi * $d->volume_realisasi,0,',','.') }}</td>
                                <td>{{ $d->jenis == 'ab' ? 'Barang Habis Pakai' : 'Barang Modal' }}</td>
                                <td>{{ $d->tahun_arkas }}</td>
                                <td>{{ $d->nama_role }}</td>
                                <td><span class="badge bg-primary">{{ $bos->statusBos($d->status) }}</span></td>
                                @php
                                    $vol_d = App\Models\Distribusi::where('id_realisasi', $d->id_realisasi)->sum('volume_distribusi');
                                @endphp
                                <td>{{ $vol_d ?? 0}} {{ $d->satuan }}</td>
                                <td>{{ $d->volume_realisasi - $vol_d }} {{ $d->satuan }}</td>
                                @if (Auth::user()->id_role == 1 || Auth::user()->id_role == 16 || Auth::user()->id_role == 3)
                                <td>
                                    @if ($d->status == '1')
                                        <button class="btn btn-warning btn-xs" disabled><i class="fa-solid fa-forward"></i></button>
                                    @else
                                    <button class="btn btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#c_distribusi" wire:click='cx_distribusi("{{$d->id_realisasi}}")'><i class="fa-solid fa-forward"></i></button>
                                    @endif
                                @if(Auth::user()->id_role != 3)
                                <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_realisasi}}")'><i class="fa-solid fa-edit"></i></i></a>
                                <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_realisasi}}')"><i class="fa-solid fa-trash"></i></a>
                                @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $data->links() }}
        </div>
    </div>


    {{-- Add Modal --}}
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Nama Barang</label>
                        <input type="text" wire:model.live="nama_barang" class="form-control">
                        <div class="text-danger">
                            @error('nama_barang')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama Kegiatan</label>
                        <input type="text" wire:model.live="nama_kegiatan" class="form-control">
                        <div class="text-danger">
                            @error('nama_kegiatan')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Volume</label>
                        <input type="text" wire:model.live="volume" class="form-control">
                        <div class="text-danger">
                            @error('volume')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Satuan</label>
                        <select class="form-control" wire:model.live="satuan">
                            <option value="">Pilih Satuan</option>
                            <option value="unit">Unit</option>
                            <option value="set">Set</option>
                            <option value="pack">Pack</option>
                            <option value="dus">Dus</option>
                        </select>
                        <div class="text-danger">
                            @error('satuan')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Perkiraan Harga Satuan</label>
                        <input type="number" wire:model.live="perkiraan_harga" class="form-control">
                        <div class="text-danger">
                            @error('perkiraan_harga')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Bulan Pengajuan</label>
                        <select class="form-control" wire:model.live="bulan_pengajuan">
                            <option value="">Pilih Bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April"> April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        <div class="text-danger">
                            @error('bulan_pengajuan')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Jenis Barang</label>
                        <select class="form-control" wire:model.live ="jenis">
                            <option value="">Pilih Jenis Barang</option>
                            <option value="ab">Barang Habis Pakai</option>
                            <option value="b">Barang Modal</option>
                        </select>
                        <div class="text-danger">
                            @error('jenis')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Tahun Arkas</label>
                        <select class="form-control" wire:model.live ="tahun_arkas">
                            <option value="">Pilih Tahun Arkas</option>
                            <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                        </select>
                        <div class="text-danger">
                            @error('jenis')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Unit</label>
                        <select class="form-control" wire:model="id_role">
                            <option value="">Pilih Unit</option>
                            @foreach ($role as $r)
                                <option value="{{ $r->id_role }}">{{ $r->nama_role }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">
                            @error('id_role')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click='insert()'>Save changes</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Edit Modal --}}
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Volume Realisasi</label>
                        <input type="text" wire:model.live="volume_realisasi" class="form-control">
                        <div class="text-danger">
                            @error('volume_realisasi')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Perkiraan Harga Realisasi</label>
                        <input type="number" wire:model.live="perkiraan_harga_realisasi" class="form-control">
                        <div class="text-danger">
                            @error('perkiraan_harga_realisasi')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Bulan Pengajuan Realisasi</label>
                        <select class="form-control" wire:model.live="bulan_pengajuan_realisasi">
                            <option value="">Pilih Bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April"> April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        <div class="text-danger">
                            @error('bulan_pengajuan_realisasi')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select class="form-control" wire:model="status">
                            <option value="">Pilih Status</option>
                            <option value="1">Disetujui</option>
                            <option value="2">Realisasi</option>
                        </select>
                        <div class="text-danger">
                            @error('status')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click='update()'>Save changes</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="konf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Nama Barang</label>
                        <input type="text" wire:model.live="nama_barang" class="form-control" disabled>
                        <div class="text-danger">
                            @error('nama_barang')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama Kegiatan</label>
                        <input type="text" wire:model.live="nama_kegiatan" class="form-control" disabled>
                        <div class="text-danger">
                            @error('nama_kegiatan')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Volume</label>
                        <input type="text" wire:model.live="volume" class="form-control" disabled>
                        <div class="text-danger">
                            @error('volume')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Volume yang di ACC</label>
                        <input type="text" wire:model.live="volume_realisasi" class="form-control">
                        <div class="text-danger">
                            @error('volume_realisasi')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Satuan</label>
                        <select class="form-control" wire:model.live="satuan" disabled>
                            <option value="">Pilih Satuan</option>
                            <option value="unit">Unit</option>
                            <option value="set">Set</option>
                            <option value="pack">Pack</option>
                            <option value="dus">Dus</option>
                        </select>
                        <div class="text-danger">
                            @error('satuan')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Perkiraan Harga</label>
                        <input type="number" wire:model.live="perkiraan_harga" class="form-control" disabled>
                        <div class="text-danger">
                            @error('perkiraan_harga')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Perkiraan Harga Realisasi</label>
                        <input type="number" wire:model.live="perkiraan_harga_realisasi" class="form-control">
                        <div class="text-danger">
                            @error('perkiraan_harga_realisasi')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Bulan Pengajuan</label>
                        <select class="form-control" wire:model.live="bulan_pengajuan" disabled>
                            <option value="">Pilih Bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April"> April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        <div class="text-danger">
                            @error('bulan_pengajuan')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Bulan Pengajuan Realisasi</label>
                        <select class="form-control" wire:model.live="bulan_pengajuan_realisasi">
                            <option value="">Pilih Bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April"> April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        <div class="text-danger">
                            @error('bulan_pengajuan')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Jenis Barang</label>
                        <select class="form-control" wire:model.live ="jenis" disabled>
                            <option value="">Pilih Jenis Barang</option>
                            <option value="ab">Barang Habis Pakai</option>
                            <option value="b">Barang Modal</option>
                        </select>
                        <div class="text-danger">
                            @error('jenis')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Tahun Arkas</label>
                        <select class="form-control" wire:model.live ="tahun_arkas" disabled>
                            <option value="">Pilih Tahun Arkas</option>
                            <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                        </select>
                        <div class="text-danger">
                            @error('jenis')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Unit</label>
                        <select class="form-control" wire:model="id_role" disabled>
                            <option value="">Pilih Unit</option>
                            @foreach ($role as $r)
                                <option value="{{ $r->id_role }}">{{ $r->nama_role }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">
                            @error('id_role')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click='realisasi()'>Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete Modal --}}
    <div class="modal fade" id="k_hapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click='delete()'>Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="c_distribusi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Distribusi Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Jumlah Distribusi</label>
                        <input type="number" class="form-control" wire:model="volume_distribusi">
                    </div>
                    <div class="text-danger">
                        @error('volume_distribusi')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Unit</label>
                        <select class="form-control" wire:model.live="id_role">
                            <option value="">Pilih Unit</option>
                            @foreach ($role as $x)
                                <option value="{{ $x->id_role }}">{{ $x->nama_role }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">
                            @error('id_role')
                                {{ $message }}
                            @enderror
                        </div>
            </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click='distribusi()'>Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('closeModal', event => {
            $('#add').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#edit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#konf').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#c_distribusi').modal('hide');
        })
    </script>

</div>
