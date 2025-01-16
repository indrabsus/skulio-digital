<div>
    Kode Mesin : {{ Session::get('kode_mesin') }} {{ $konek ? "Mesin Fingerprint Terhubung" : "Mesin Fingerprint Tidak Terhubung" }}
    <hr>

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
                        <button type="button" class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#add">
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
                            <input type="text" class="form-control" placeholder="Cari..." aria-label="Username" aria-describedby="basic-addon1" wire:model.live="cari">
                            <span class="input-group-text" id="basic-addon1">Cari</span>
                          </div>
                    </div>
                </div>
                {{-- @if (!Session::get('kode_mesin'))
                <div>
                    <form action="{{ route('sesimesin') }}" method="post">
                        <div class="row">
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name='kode_mesin' placeholder="Masukan Kode Mesin">
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-primary btn-sm">Submit</button>
                            </div>
                    </div>
                    </form>
                </div>
                @endif --}}

               <div class="table-responsive">
                <table class="table table-stripped">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Username</th>
                          <th>Nama Lengkap</th>
                          <th>Jenis Kelamin</th>
                          <th>Role</th>
                          @if (Auth::user()->id_role == 1)
                          <th>Fingerprint</th>
                          @endif
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}
                        </td>
                        <td> @if (Auth::user()->id_role == 1)
                          <a href="{{ route('admin.tambahkartu') }}?id_user={{$d->id}}">{{$d->username}}</a>
                          @else
                          {{$d->username}}
                          @endif
                      </td>
                          <td>{{$d->nama_lengkap}} @if ($d->no_rfid)
                            <i class="fa-solid fa-check">
                            @endif</td>
                          <td>{{$d->jenkel == 'l' ? 'Laki-laki' : 'Perempuan'}}</td>
                          <td>{{$d->nama_role}}</td>
                          @if (Auth::user()->id_role == 1)
                          <td><button class="btn btn-primary btn-xs" wire:click='insertUser("{{$d->id_data}}")'><i class="fa-solid fa-share"></i></i></a></td>
                          @endif
                          <td>
                              <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_data}}")'><i class="fa-solid fa-edit"></i></i></a>
                              @if (Auth::user()->id_role == 1)
                              <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id}}')"><i class="fa-solid fa-trash"></i></a>
                              <a href="" class="btn btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#k_reset" wire:click="c_reset('{{$d->id}}')"><i class="fa-solid fa-rotate-right"></i></a>
                           @endif
                            </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>
               </div>
                {{$data->links()}}
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
                    <label for="">Nama Lengkap</label>
                    <input type="text" wire:model.live="nama_lengkap" class="form-control">
                    <div class="text-danger">
                        @error('nama_lengkap')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Jenis Kelamin</label>
                    <select class="form-control" wire:model.live="jenkel">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="l">Laki-laki</option>
                        <option value="p">Perempuan</option>
                    </select>
                    <div class="text-danger">
                        @error('jenkel')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Role</label>
                    <select class="form-control" wire:model.live="id_role">
                        <option value="">Pilih Role</option>
                        <option value="6">Guru</option>
                        <option value="7">Tendik</option>
                    </select>
                    <div class="text-danger">
                        @error('id_role')
                            {{$message}}
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
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-group mb-3">
                    <label for="">Nama Lengkap</label>
                    <input type="text" wire:model.live="nama_lengkap" class="form-control">
                    <div class="text-danger">
                        @error('nama_lengkap')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Jenis Kelamin</label>
                    <select class="form-control" wire:model.live="jenkel">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="l">Laki-laki</option>
                        <option value="p">Perempuan</option>
                    </select>
                    <div class="text-danger">
                        @error('jenkel')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Role</label>
                    <select class="form-control" wire:model.live="id_role">
                        <option value="">Pilih Role</option>
                        <option value="6">Guru</option>
                        <option value="7">Tendik</option>
                    </select>
                    <div class="text-danger">
                        @error('id_role')
                            {{$message}}
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

      <div class="modal fade" id="k_reset" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Reset Passwort</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin mereset password user ini?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='p_reset()'>Save changes</button>
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
            $('#k_reset').modal('hide');
        })
      </script>

</div>

