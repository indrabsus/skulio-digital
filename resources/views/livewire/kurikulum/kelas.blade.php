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
                <div class="table-responsive">
                  <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th>Jurusan</th>
                            <th>Tahun Masuk</th>
                            <th>Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                            <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                            <td>{{ DB::table('data_siswa')->leftJoin('users','users.id','data_siswa.id_user')->where('id_kelas', $d->id_kelas)->where('acc','y')->count() }}</td>
                            <td>{{$d->nama_jurusan}}</td>
                            <td>{{$d->tahun_masuk}}</td>
                            <td>{{$d->username}}</td>
                            <td>
                                <a href="{{ route('printkelas', ['id_kelas' => $d->id_kelas]) }}" class="btn btn-primary btn-xs"  target="_blank"><i class="fa-solid fa-print"></i></a>
                              <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_kelas}}")'><i class="fa-solid fa-edit"></i></i></a>
                              <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_kelas}}')"><i class="fa-solid fa-trash"></i></a>
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
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="">Tingkat</label>
                    <input type="number" wire:model.live="tingkat" class="form-control">
                    <div class="text-danger">
                        @error('tingkat')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="">Jurusan</label>
                    <select class="form-control" wire:model="id_jurusan">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusan as $j)
                            <option value="{{$j->id_jurusan}}">{{$j->nama_jurusan}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_jurusan')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="">Kelas</label>
                    <input type="number" wire:model.live="nama_kelas" class="form-control">
                    <div class="text-danger">
                        @error('nama_kelas')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                    <label for="">Tahun Masuk</label>
                    <select class="form-control" wire:model="id_angkatan">
                        <option value="">Pilih Tahun Masuk</option>
                        @foreach ($angkatan as $j)
                            <option value="{{$j->id_angkatan}}">{{$j->tahun_masuk}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_angkatan')
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
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="">Tingkat</label>
                    <input type="number" wire:model.live="tingkat" class="form-control">
                    <div class="text-danger">
                        @error('tingkat')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="">Jurusan</label>
                    <select class="form-control" wire:model="id_jurusan">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusan as $j)
                            <option value="{{$j->id_jurusan}}">{{$j->nama_jurusan}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_jurusan')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="">Kelas</label>
                    <input type="number" wire:model.live="nama_kelas" class="form-control">
                    <div class="text-danger">
                        @error('nama_kelas')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                    <label for="">Tahun Masuk</label>
                    <select class="form-control" wire:model="id_angkatan">
                        <option value="">Pilih Tahun Masuk</option>
                        @foreach ($angkatan as $j)
                            <option value="{{$j->id_angkatan}}">{{$j->tahun_masuk}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_angkatan')
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

