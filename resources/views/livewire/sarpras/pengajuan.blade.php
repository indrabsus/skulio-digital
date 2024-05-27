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
                    <button type="button" class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal"
                        data-bs-target="#add">
                        Tambah
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
                            <th>Jumlah</th>
                            <th>Bulan Pengajuan</th>
                            <th>Jenis</th>
                            <th>Tahun Arkas</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                            <th>Unit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                                <td>{{ $d->nama_barang }}</td>
                                <td>{{ $d->volume }} {{ $d->satuan }}</td>
                                <td>{{ $d->bulan_pengajuan }}</td>
                                <td>{{ $d->jenis == 'ab' ? 'Barang Habis Pakai' : 'Barang Modal' }}</td>
                                <td>{{ $d->tahun_arkas }}</td>
                                <td>Rp.{{ number_format($d->perkiraan_harga,0,',','.') }}</td>
                                <td>Rp.{{ number_format($d->perkiraan_harga * $d->volume,0,',','.') }}</td>
                                <td>{{ $d->nama_role }}</td>
                                <td>
                                    <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_pengajuan}}")'><i class="fa-solid fa-edit"></i></i></a>
                              <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_pengajuan}}')"><i class="fa-solid fa-trash"></i></a>
                                </td>
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
                        <label for="">Nama Barang</label>
                        <input type="text" wire:model.live="nama_barang" class="form-control">
                        <div class="text-danger">
                            @error('nama_barang')
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
                    <button type="button" class="btn btn-primary" wire:click='update()'>Save changes</button>
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
    </script>

</div>
