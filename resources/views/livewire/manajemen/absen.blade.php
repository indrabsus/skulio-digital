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
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#add">
                            Absen Guru
                          </button>
                    </div>
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-success btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#izin">
                            Absen Tendik
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
               <div class="table-responsive">
                <table class="table table-stripped">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Role</th>
                          <th>Waktu</th>
                          <th>Status</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_lengkap}}</td>
                          <td>{{ucwords($d->nama_role)}}</td>
                          <td>{{ date('d F Y - h:i:s A', strtotime($d->waktu)) }}</td>
                          <td>
                            @if ($d->status == 0)
                            <span class="badge bg-primary">Datang</span>
                            @elseif($d->status == 1)
                            <span class="badge bg-success">Tidak Ada Jadwal</span>
                            @elseif($d->status == 2)
                            <span class="badge bg-secondary">Sakit</span>
                            @elseif($d->status == 3)
                            <span class="badge bg-danger">Izin</span>
                            @endif
                           </td>
                          <td><a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_absen}}')"><i class="fa-solid fa-trash"></i></a>
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
              <h5 class="modal-title" id="exampleModalLabel">Absen</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="">Nama</label>
                    <select wire:model="id_user" class="form-control">
                        <option value="">Pilih User</option>
                        @foreach ($guru as $u)
                            <option value="{{ $u->id }}">{{ $u->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_user')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                @if (Auth::user()->id_role == 1)
                <div class="form-group mb-3">
                    <label for="">Tanggal</label>
                    <input type="datetime-local" class="form-control" wire:model="waktu">
                    <div class="text-danger">
                        @error('waktu')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                @endif
                <div class="form-group mb-3">
                    <label for="">Keterangan</label>
                    <select wire:model="status" class="form-control">
                        <option value="">Pilih Keterangan</option>
                        <option value="0">Hadir</option>
                        <option value="1">Tidak ada jadwal</option>
                        <option value="2">Sakit</option>
                        <option value="3">Izin</option>
                    </select>
                    <div class="text-danger">
                        @error('status')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='hadir()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>


    {{-- Edit Modal --}}
    <div class="modal fade" id="izin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="">Nama</label>
                    <select wire:model="id_user" class="form-control">
                        <option value="">Pilih User</option>
                        @foreach ($tendik as $u)
                            <option value="{{ $u->id }}">{{ $u->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_user')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                @if (Auth::user()->id_role == 1)
                <div class="form-group mb-3">
                    <label for="">Tanggal</label>
                    <input type="datetime-local" class="form-control" wire:model="waktu">
                    <div class="text-danger">
                        @error('waktu')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                @endif
                <div class="form-group mb-3">
                    <label for="">Keterangan</label>
                    <select wire:model="status" class="form-control">
                        <option value="">Pilih Keterangan</option>
                        <option value="0">Hadir</option>
                        <option value="1">Tidak ada jadwal</option>
                        <option value="2">Sakit</option>
                        <option value="3">Izin</option>
                    </select>
                    <div class="text-danger">
                        @error('status')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='izin()'>Save changes</button>
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
            $('#izin').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_reset').modal('hide');
        })
      </script>

</div>

