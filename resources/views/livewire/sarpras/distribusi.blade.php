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
                </div>
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-3">
                        <div class="col-3">
                            <select class="form-control" wire:model.live="cari_unit">
                                <option value="">Pilih Unit</option>
                                @foreach ($role as $dr)
                                    <option value="{{ $dr->nama_role }}">{{ $dr->nama_role }}</option>
                                @endforeach
                            </select>
                        </div>
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
                            <th>Distribusi</th>
                            <th>Tahun Arkas</th>
                            <th>Jenis Barang</th>
                            <th>Tanggal Distribusi</th>
                            <th>Unit</th>
                            @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 3)
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                                <td>{{ $d->nama_barang }}</td>
                                <td>{{ $d->volume_distribusi }} {{ $d->satuan }}</td>
                               <td>{{ $d->tahun_arkas }}</td>
                                <td>{{ $d->jenis == 'ab' ? 'Barang Habis Pakai' : 'Barang Modal' }}</td>
                                <td>{{ date('d F Y H:i A', strtotime($d->created_at)) }}</td>
                                <td>{{ $d->nama_role}}</td>
                                @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 3)
                                <td>
                                    <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_distribusi}}')"><i class="fa-solid fa-trash"></i></a>
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
