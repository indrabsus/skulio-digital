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
                            <div class="form-group">
                                <select class="form-control" wire:model.live="cari_kelas">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                    <option value="{{$k->id_kelas}}">{{$k->tingkat.' '.$k->singkatan.' '.$k->nama_kelas}}</option>
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
                          <th>Nama Guru</th>
                          <th>Kelas</th>
                          <th>Tahun</th>
                          <th>Hari</th>
                          <th>Aktif?</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_pelajaran}}</td>
                          <td>{{$d->nama_lengkap}}</td>
                          <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                          <td>{{ $d->tahun }}</td>
                          @php
    // Debug nilai hari yang diterima
    $hariValues = is_string($d->hari) ? explode(',', $d->hari) : (array)$d->hari;
@endphp
                          <td>{{ $fungsi->hari($hariValues) }}</td>
                          <td>@if ($d->aktif == 'y')
                            <i class="fa-solid fa-check"></i>
                          @else
                          <i class="fa-solid fa-times"></i>
                          @endif</td>
                          <td>
                            <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_mapelkelas}}")'><i class="fa-solid fa-edit"></i></i></a>
                            @if (Auth::user()->id_role != 5)
                            <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_mapelkelas}}')"><i class="fa-solid fa-trash"></i></a>
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
                @if (Auth::user()->id_role != 5)
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
                @endif
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
                    <div>
                        <label><input type="checkbox" wire:model.live="hari.1" value="1"> Senin</label>
                    </div>
                    <div>
                        <label><input type="checkbox" wire:model.live="hari.2" value="2"> Selasa</label>
                    </div>
                    <div>
                        <label><input type="checkbox" wire:model.live="hari.3" value="3"> Rabu</label>
                    </div>
                    <div>
                        <label><input type="checkbox" wire:model.live="hari.4" value="4"> Kamis</label>
                    </div>
                    <div>
                        <label><input type="checkbox" wire:model.live="hari.5" value="5"> Jumat</label>
                    </div>

                    <div class="text-danger">
                        @error('hari')
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
            <div class="form-group">
                <label for="">Mata Pelajaran</label>
                <select class="form-control" wire:model.live="id_mapel" disabled>
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
            @if (Auth::user()->id_role != 5)
            <div class="form-group">
                <label for="">Kelas</label>
                <select class="form-control" wire:model.live="id_kelas" disabled>
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
            @endif
              <div class="form-group">
                <label for="">Tahun</label>
                <select class="form-control" wire:model.live="tahun" disabled>
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
                <select class="form-control" wire:model.live="id_user" disabled>
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
                <div>
                    <label><input type="checkbox" wire:model.live="hari.1" value="1"> Senin</label>
                </div>
                <div>
                    <label><input type="checkbox" wire:model.live="hari.2" value="2"> Selasa</label>
                </div>
                <div>
                    <label><input type="checkbox" wire:model.live="hari.3" value="3"> Rabu</label>
                </div>
                <div>
                    <label><input type="checkbox" wire:model.live="hari.4" value="4"> Kamis</label>
                </div>
                <div>
                    <label><input type="checkbox" wire:model.live="hari.5" value="5"> Jumat</label>
                </div>

                <div class="text-danger">
                    @error('hari')
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

