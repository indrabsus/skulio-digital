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
                          <th>Mapel</th>
                          <th>Kelas</th>
                          @if (Auth::user()->id_role == 8)
                          <th>Aksi</th>
                          @endif
                          @if (Auth::user()->id_role == 6)
                          <th>Token</th>
                          <th>Tahun</th>
                          <th>Waktu</th>
                          <th>Soal</th>
                          <th>Aksi</th>
                          @endif

                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_sumatif}}</td>
                          <td>{{ $d->nama_pelajaran }}</td>
                          <td>{{ $d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas }}</td>

                          @php
                          if (Auth::user()->id_role == 8) {
                            $us = App\Models\DataSiswa::where('id_user',Auth::user()->id)->first();
                              $jml = App\Models\NilaiUjian::where('id_sumatif', $d->id_sumatif)
                              ->where('id_user_siswa', $us->id_user)
                              ->where('jawaban_siswa', '!=', null)
                              ->count();
                          }
                          @endphp

                          @if (Auth::user()->id_role == 8)
                          <td>
                            @if ($jml > 0)
                            <button disabled class="btn btn-primary btn-xs"><i class="fa-solid fa-share"></i></button>
                            @else
                            <a href="{{ route('token2',['id' => $d->id_sumatif]) }}" class="btn btn-primary btn-xs"><i class="fa-solid fa-share"></i></a>
                            @endif
                            </td>
                          @endif
                          @if (Auth::user()->id_role == 6)
                          <td>{{$d->token}}</td>
                          <td>{{$d->tahun}}</td>
                          <td>{{$d->waktu}} Menit</td>
                          <td>{{ $d->nama_soal }}</td>
                          <td>
                            <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_sumatif}}")'><i class="fa-solid fa-edit"></i></i></a>
                            <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_sumatif}}')"><i class="fa-solid fa-trash"></i></a>
                          </td>
                          @endif
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
                    <label for="">Kategori Soal</label>
                    <select class="form-control" wire:model="id_soalujian">
                        <option value="">Pilih Soal</option>
                        @foreach ($tampung as $t)
                            <option value="{{ $t->id_soalujian }}">{{ $t->nama_soal }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_soalujian')
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
                    ->leftJoin('mata_pelajaran', 'mata_pelajaran.id_mapel', '=', 'mapel_kelas.id_mapel')
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
                    <input class="form-check-input" type="checkbox" wire:model="kelasku" value="{{ $k->id_mapelkelas }}">
                    <label class="form-check-label">{{ $k->tingkat.' '.$k->singkatan.' '.$k->nama_kelas }} - {{ $k->nama_pelajaran }}</label>
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

