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
                          <th>Nama Sumatif</th>
                          <th>Token</th>
                          <th>Tahun</th>
                          <th>Waktu</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_sumatif}}</td>
                          <td>{{$d->token}}</td>
                          <td>{{$d->tahun}}</td>
                          <td>{{$d->waktu}} Menit</td>
                          <td>
                            <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_sumatif}}")'><i class="fa-solid fa-edit"></i></i></a>
                            <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_sumatif}}')"><i class="fa-solid fa-trash"></i></a>
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
                    <label for="">Nama Sumatif</label>
                    <input type="text" wire:model.live="nama_sumatif" class="form-control">
                    <div class="text-danger">
                        @error('nama_sumatif')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Token</label>
                    <input type="number" wire:model.live="token" class="form-control">
                    <div class="text-danger">
                        @error('token')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Waktu</label>
                    <input type="number" wire:model.live="waktu" class="form-control">
                    <div class="text-danger">
                        @error('waktu')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Tahun</label>
                    <select wire:model.live="tahun" class="form-control">
                        <option value="">Pilih Tahun</option>
                        <option value="{{ date('Y') - 1}}">{{ date('Y') -1}}</option>
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option value="{{ date('Y') + 1}}">{{ date('Y') + 1}}</option>
                    </select>
                    <div class="text-danger">
                        @error('tahun')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  @php
                    $kls = App\Models\Kelas::leftJoin('jurusan', 'jurusan.id_jurusan', '=', 'kelas.id_jurusan')
                    ->leftJoin('mapel_kelas', 'mapel_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->where('mapel_kelas.id_user', Auth::user()->id)
                    ->orderBy('tingkat', 'asc')
                    ->orderBy('singkatan', 'asc')
                    ->orderBy('nama_kelas', 'asc')
                    ->get();
                @endphp

                  <div class="form-group mb-3">
                    <label for="">Pilih Kelas</label>
                    @foreach ($kls as $k)
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model="kelasku" value="{{ $k->id_kelas }}">
                    <label class="form-check-label">{{ $k->tingkat.' '.$k->singkatan.' '.$k->nama_kelas }}</label>
                    </div>
                    @endforeach


                <div class="text-danger">
                    @error('kelasku')
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
                    <label for="">Nama Sumatif</label>
                    <input type="text" wire:model.live="nama_sumatif" class="form-control">
                    <div class="text-danger">
                        @error('nama_sumatif')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Token</label>
                    <input type="number" wire:model.live="token" class="form-control">
                    <div class="text-danger">
                        @error('token')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Waktu</label>
                    <input type="number" wire:model.live="waktu" class="form-control">
                    <div class="text-danger">
                        @error('waktu')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Tahun</label>
                    <select wire:model.live="tahun" class="form-control">
                        <option value="">Pilih Tahun</option>
                        <option value="{{ date('Y') - 1}}">{{ date('Y') -1}}</option>
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option value="{{ date('Y') + 1}}">{{ date('Y') + 1}}</option>
                    </select>
                    <div class="text-danger">
                        @error('tahun')
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
        window.addEventListener('closeModal', event => {
            $('#k_kelas').modal('hide');
        })
      </script>

</div>

