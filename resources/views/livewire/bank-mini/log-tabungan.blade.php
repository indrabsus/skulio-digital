<div>
    <div class="row">

        <div class="container">
            @if(session('sukses'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h5>Sukses!</h5>
                    {{ session('sukses') }}
                </div>
            @endif
            @if(session('gagal'))
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
                            <th>Print</th>
                            <th>Nama Siswa</th>
                            <th>Nominal</th>
                            <th>No Invoice</th>
                            <th>Jenis</th>
                            <th>log</th>
                            @if (Auth::user()->id_role == 1)
                            <th>Hapus</th>
                          @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                            <tr>
                                <td><a href="{{ route('printLog', ['id_log' => $d->id_log_tabungan]) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa-solid fa-print"></i></a>
                                </td>
                                <td>{{ $d->nama_lengkap }}</td>
                                <td>Rp.{{ number_format($d->nominal,0,',','.') }}</td>
                                <td>{{ $d->no_invoice }}</td>
                                <td>{{ $d->jenis == 'db' ? 'Debit' : 'Kredit' }}
                                </td>
                                <td>{{ date('d M Y h:i A') }}</td>
                                @if (Auth::user()->id_role == 1)
                                <td><a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="k_delete({{$d->id_log_tabungan}})"><i class="fa-solid fa-trash"></i></a></td>
                          @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $data->links() }}
        </div>
    </div>
    <div class="modal fade" id="k_hapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
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
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#debit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('kredit').modal('hide');
        })

    </script>

</div>
