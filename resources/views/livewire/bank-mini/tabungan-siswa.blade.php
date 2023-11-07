<div>
    <div class="row">

        <div class="container">
          @if(session('sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h5>Sukses!</h5>
        {{session('sukses')}}
        </div>
        @endif
        @if(session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h5>Gagal!</h5>
        {{session('gagal')}}
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
                            <input type="text" class="form-control" placeholder="Cari..." aria-label="Username" aria-describedby="basic-addon1" wire:model.live="cari">
                            <span class="input-group-text" id="basic-addon1">Cari</span>
                          </div>
                    </div>
                </div>
               <div class="table-responsive">
                <table class="table table-stripped">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Nama Siswa</th>
                           <th>Jenis kelamin</th>          
                          <th>No_Hp</th>                    
                          <th>Jumlah Saldo</th>                    
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_lengkap}}</td>
                          <td>{{$d->jenkel == 'l' ? 'Laki-Laki' : 'Prempuan'  }}</td>
                          <td>{{$d->no_hp}}</td>
                          <td>Rp.{{ number_format($d->jumlah_saldo) }}</td>
                          <td>
                            <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#debit" wire:click='debit({{$d->id_siswa}})'><i class="fa-solid fa-wallet"></i></i></a>
                            <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#kredit" wire:click="kredit({{$d->id_siswa}})"><i class="fa-solid fa-hand-holding-dollar"></i></i></a>
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>
               </div>
                {{$data->links()}}
        </div>
    </div>

    {{-- debit --}}
    <div class="modal fade" id="debit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-3">
              <div class="form-group">
                <label for="">nama_lengkap</label>
                <input type="text" wire:model.live="nama_lengkap" class="form-control" disabled>
                <div class="text-danger">
                    @error('nama_lengkap')
                        {{$message}}
                    @enderror
                </div>
              </div>
                <div class="form-group mb-3">
                    <label for="">Nominal</label>
                    <input type="text" wire:model.live="nominal" class="form-control">
                    Rp.{{number_format(floatval($nominal))}}
                    <div class="text-danger">
                        @error('nominal')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
            
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='debitmasuk()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>

    {{-- kredit --}}
    <div class="modal fade" id="kredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-body">
              <div class="form-group mb-3">
                <label for="">nama_lengkap</label>
                <input type="text" wire:model.live="nama_lengkap" class="form-control" disabled>
                <div class="text-danger">
                    @error('nama_lengkap')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group mb-3">
                  <label for="">Nominal</label>
                  <input type="text" wire:model.live="nominal" class="form-control">
                  Rp.{{number_format(floatval($nominal))}}
                  <div class="text-danger">
                      @error('nominal')
                          {{$message}}
                      @enderror
                  </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" wire:click='kreditkeluar'>Save changes</button>
          </div>
        </div>
      </div>
    </div>
      <script>
        window.addEventListener('closeModal', event => {
            $('#add').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#debit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#kredit').modal('hide');
        })
      </script>

</div>


