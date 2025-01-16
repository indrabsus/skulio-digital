<div>
   <div class="row">
    <div class="col-lg-6">
        <button type="button" class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#add">
            Tambah
          </button>
    </div>
   </div>
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
            <div class="row justify-content-between mt-2">
                <div class="col-lg-6">
                    <form action="{{ route('rekaphariankeuangan') }}" method="get" target="_blank">
                        <div class="input-group input-group-sm mb-3">
                            <div class="col-3">
                                <input type="date" class="form-control" name="date">
                          </div>
                             <button class="input-group-text" id="basic-addon1">Print</button>
                            </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-3">
                        <div class="col-3">
                                <form action="{{route('printkeuanganbulanan')}}" method="get" target="_blank">
                                <select class="form-control" name="bln">
                                    <option value="">Pilih Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-control" name="thn">
                                    <option value="">Pilih Tahun</option>
                                    <option value="{{date('Y') - 1}}">{{date('Y') - 1}}</option>
                                    <option value="{{date('Y') }}">{{date('Y') }}</option>
                                    <option value="{{date('Y') + 1}}">{{date('Y') + 1}}</option>
                                </select>
                            </div>
                            <button class="input-group-text" type="submit">Print</button>
                        </form>
                        </div>
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
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th>Jenis</th>
                            <th>Via</th>
                            <th>Waktu</th>
                            @if (Auth::user()->id_role != 14)
                            <th>Hapus</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                            <tr>
                                <td><a href="{{ route('printstruk',['id_logluar' => $d->id_logluar]) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa-solid fa-print"></i></a></td>
                                <td>{{ $d->keterangan }}</td>
                                <td>Rp. {{ number_format($d->nominal,0,',','.') }}</td>
                                <td>{{ $d->jenis == 'm' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                                <td>{{ $d->via == 'trf' ? 'Transfer' : 'Tunai' }}</td>
                                <td>{{ date('d/M/Y H:i', strtotime($d->created_at)) }}</td>
                                @if (Auth::user()->id_role != 14)
                            <td>
                                <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_logluar}}")'><i class="fa-solid fa-edit"></i></i></a>
                                    <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="k_delete('{{$d->id_logluar}}')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                            @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $data->links() }}
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

      {{-- Add Modal --}}
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" wire:model="keterangan" class="form-control">
                    <div class="text-danger">
                        @error('keterangan')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="nominal">Nominal</label>
                    <input type="number" wire:model="nominal" class="form-control">
                    <div class="text-danger">
                        @error('nominal')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select class="form-control" wire:model="status">
                        <option value="">Pilih Status</option>
                        <option value="m">Pemasukan</option>
                        <option value="k">Pengeluaran</option>
                    </select>
                    <div class="text-danger">
                        @error('status')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="status">Via</label>
                    <select class="form-control" wire:model="via">
                        <option value="">Pilih Cara Bayar</option>
                        <option value="trf">Transfer</option>
                        <option value="cash">Tunai</option>
                    </select>
                    <div class="text-danger">
                        @error('via')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group mb-3">
                    <label for="waktu-bayar">Waktu Bayar</label>
                    <input type="datetime-local" id="waktu-bayar" wire:model="created_at" class="form-control">
                    <div class="text-danger">
                        @error('created_at')
                            {{ $message }}
                        @enderror
                    </div>
                </div> --}}
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='create()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>



    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" wire:model="keterangan" class="form-control">
                    <div class="text-danger">
                        @error('keterangan')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="nominal">Nominal</label>
                    <input type="number" wire:model="nominal" class="form-control">
                    <div class="text-danger">
                        @error('nominal')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select class="form-control" wire:model="status">
                        <option value="">Pilih Status</option>
                        <option value="m">Pemasukan</option>
                        <option value="k">Pengeluaran</option>
                    </select>
                    <div class="text-danger">
                        @error('status')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="status">Via</label>
                    <select class="form-control" wire:model="via">
                        <option value="">Pilih Cara Bayar</option>
                        <option value="trf">Transfer</option>
                        <option value="cash">Tunai</option>
                    </select>
                    <div class="text-danger">
                        @error('via')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="waktu-bayar">Waktu Bayar</label>
                    <input type="datetime-local" id="waktu-bayar" wire:model="created_at" class="form-control">
                    <div class="text-danger">
                        @error('created_at')
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
    <script>
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#add').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#edit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('kredit').modal('hide');
        })

    </script>

</div>
