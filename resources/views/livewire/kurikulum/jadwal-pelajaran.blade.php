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
                          <th>Nama Mapel</th>
                          <th>Kelas</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_pelajaran}}</td>
                          <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                          <td>
                            @php
                                $cek = \App\Models\Materi::where('id_mapelkelas', $d->id_mapelkelas)
                                ->whereDate('created_at', now()->format('Y-m-d'))->count();
                            @endphp
                           @if (Auth::user()->id_role == 6)
                           @if ($cek  > 0)
                           <a href="" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#isi" wire:click='isi("{{$d->id_mapelkelas}}")'>Edit Agenda</a>
                           @else
                           <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#isi" wire:click='isi("{{$d->id_mapelkelas}}")'>Isi Agenda</a>
                           @endif
                           @elseif(Auth::user()->id_role == 5)
                           @php
                                $cek2 = \App\Models\Materi::where('id_mapelkelas', $d->id_mapelkelas)
                                ->whereDate('created_at', now()->format('Y-m-d'))->where('keterangan', '!=', null)->count();
                        //    dd($cek);
                           @endphp
                           @if($cek2 > 0)
                           <button class="btn btn-warning btn-xs" disabled>Sudah Konfirmasi</button>
                           @else
                           <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#konf" wire:click='konf("{{$d->id_mapelkelas}}")'>Konfirmasi</a>
                           @endif
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

    <div class="modal fade" id="konf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="">Keterangan Pembelajaran</label>
                    <select class="form-control" wire:model.live="konfirmasi">
                        <option value="">Pilih Opsi</option>
                        <option value="1">Hadir</option>
                        <option value="2">Tidak hadir (Penugasan)</option>
                        <option value="3">Tidak hadir Tanpa Keterangan</option>
                    </select>
                    <div class="text-danger">
                        @error('konfirmasi')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='verify()'>Save changes</button>
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
                <div class="form-group">
                    <label for="">Mata Pelajaran</label>
                    <select class="form-control" wire:model.live="id_mapel">
                        <option value="">Pilih Mapel</option>
                        @foreach ($mapel as $m)
                            <option value="{{$m->id_mapel}}">{{$m->nama_pelajaran}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_mapel')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group">
                    <label for="">Kelas</label>
                    <select class="form-control" wire:model.live="id_kelas">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{$k->id_kelas}}">{{$k->tingkat.' '.$k->singkatan.' '.$k->nama_kelas}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_kelas')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="">Tahun</label>
                    <select class="form-control" wire:model.live="tahun">
                        <option value="">Pilih Tahun</option>
                        <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                    </select>
                    <div class="text-danger">
                        @error('tahun')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  @if (Auth::user()->id_role != 6)
                  <div class="form-group">
                    <label for="">Guru</label>
                    <select class="form-control" wire:model.live="id_user">
                        <option value="">Pilih Guru</option>
                        @foreach ($guru as $k)
                            <option value="{{$k->id_user}}">{{$k->nama_lengkap}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_user')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  @endif
                  <div class="form-group mb-3">
                    <label for="">Hari</label>
                    <select class="form-control" wire:model.live="hari">
                        <option value="">Pilih Opsi</option>
                        <option value="1">Senin</option>
                        <option value="2">Selasa</option>
                        <option value="3">Rabu</option>
                        <option value="4">Kamis</option>
                        <option value="5">Jumat</option>
                    </select>
                    <div class="text-danger">
                        @error('hari')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Jam Mulai</label>
                            <select class="form-control" wire:model.live="jam_mulai">
                                <option value="">Jam ke</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                            <div class="text-danger">
                                @error('jam_mulai')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Jam Selesai</label>
                            <select class="form-control" wire:model.live="jam_selesai">
                                <option value="">Jam ke</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                            <div class="text-danger">
                                @error('jam_selesai')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
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
    <div class="modal fade" id="isi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Isi Materi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="">Materi</label>
                <input type="text" class="form-control" wire:model='materi'>
                <div class="text-danger">
                    @error('materi')
                        {{$message}}
                    @enderror
                </div>
            </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" wire:click='prosesagenda()'>Save changes</button>
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
              <div class="form-group">
                  <label for="">Materi</label>
                  <input type="text" class="form-control" wire:model='materi'>
                  <div class="text-danger">
                      @error('materi')
                          {{$message}}
                      @enderror
                  </div>
              </div>
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='prosesagenda()'>Save changes</button>
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
            $('#isi').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#edit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#konf').modal('hide');
        })
      </script>

</div>

