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
        @php
            $ok = DB::table('master_ppdb')->get();
        @endphp
        <form action="" method="get">
          <select name="tahun" id="">
            <option value="">Pilih Tahun</option>
            @foreach ($ok as $o)
                <option value="{{$o->tahun}}">{{$o->tahun}}</option>
            @endforeach
          </select>
          <button>submit</button>
        </form>
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
                          <th>Nama Lengkap</th>
                          <th>Jenis Kelamin</th>
                          <th>No Hp</th>
                          <th>Asal Sekolah</th>
                          <th>NIS</th>
                          <th>NISN</th>
                          <th>NIK</th>
                          <th>Nama Ayah</th>
                          <th>Nama Ibu</th>
                          <th>Minat Jurusan</th>
                          <th>Bayar Daftar</th>
                          <th>Kelas</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_lengkap}}</td>
                          <td>{{$d->jenkel == 'l' ? 'Laki-laki' : 'Perempuan'}}</td>
                          <td>{{$d->no_hp}}</td> 
                          <td>{{$d->asal_sekolah}}</td>
                          <td>{{$d->nis}}</td>
                          <td>{{$d->nisn}}</td>
                          <td>{{$d->nik_siswa}}</td>
                          <td>{{$d->nama_ayah}}</td>
                          <td>{{$d->nama_ibu}}</td>
                          <td>{{$d->minat_jurusan1}} , {{$d->minat_jurusan2}}</td>
                          <td>@if ($d->bayar_daftar == 'y')
                            <button class="btn btn-outline-success btn-sm" wire:click="daftar({{ $d->id_siswa }})"><i class="fa-solid fa-check"></i></button>
                          @else
                          <button class="btn btn-outline-danger btn-sm" wire:click="daftar({{ $d->id_siswa }})"><i class="fa-solid fa-times"></i></button>
                          @endif</td>
                          <td>{{$d->nama_kelas}}</td>
                          <td>
                            @if ($d->bayar_daftar == 'y')
                              <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#bayarppdb" wire:click="ppdb({{ $d->id_siswa }})"><i class="fa-solid fa-wallet"></i></button>
                            @else
                            <button disabled class="btn btn-outline-secondary btn-sm" wire:click="({{ $d->id_siswa }})"><i class="fa-solid fa-wallet"></i></button>
                            @endif
                              <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit({{$d->id_siswa}})'><i class="fa-solid fa-edit"></i></i></a>
                              <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete({{$d->id_siswa}})"><i class="fa-solid fa-trash"></i></a>
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
                <div class="col-lg-6">
                <div class="form-group mb-3">
                    <label for="">Nama Lengkap</label>
                    <input type="text" wire:model.live="nama_lengkap" class="form-control">
                    <div class="text-danger">
                        @error('nama_lengkap')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group mb-3">
                    <label for="">No Hp</label>
                    <input type="text" wire:model.live="no_hp" class="form-control">
                    <div class="text-danger">
                        @error('no_hp')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group mb-3">
                    <label for="">NIS</label>
                    <input type="text" wire:model.live="nis" class="form-control">
                    <div class="text-danger">
                        @error('nis')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-3">
                    <label for="">NISN</label>
                    <input type="text" wire:model.live="nisn" class="form-control">
                    <div class="text-danger">
                        @error('nisn')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-3">
                    <label for="">NIK</label>
                    <input type="text" wire:model.live="nik_siswa" class="form-control">
                    <div class="text-danger">
                        @error('nik_siswa')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  </div>
                  <div class="col-lg-6">
                  <div class="form-group mb-3">
                    <label for="">Nama Ayah</label>
                    <input type="text" wire:model.live="nama_ayah" class="form-control">
                    <div class="text-danger">
                        @error('nama_ayah')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-3">
                    <label for="">Nama Ibu</label>
                    <input type="text" wire:model.live="nama_ibu" class="form-control">
                    <div class="text-danger">
                        @error('nama_ibu')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="">Asal Sekolah</label>
                        <input type="text" wire:model.live="asal_sekolah" class="form-control">
                        <div class="text-danger">
                            @error('asal_sekolah')
                                {{$message}}
                            @enderror
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="">Minat Jurusan 1</label><br>
                            <input type="radio" wire:model.live="minat_jurusan1" value="Rekayasa Perangkat Lunak">
                            <label for="">Rekayasa Perangkat Lunak</label><br>
                            <input type="radio" wire:model.live="minat_jurusan1" value="Akutansi">
                            <label for="">Akutansi</label><br>
                            <input type="radio" wire:model.live="minat_jurusan1" value="Pemasaran">
                            <label for="">Pemasaran</label><br>
                            <input type="radio" wire:model.live="minat_jurusan1" value="Perkantoran">
                            <label for="">Perkantoran</label><br>
                            <div class="text-danger">
                                @error('minat_jurusan1')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <div class="form-group">
                          <label for="">Minat Jurusan 2</label><br>
                          <input type="radio" wire:model.live="minat_jurusan2" value="Rekayasa Perangkat Lunak">
                          <label for="">Rekayasa Perangkat Lunak</label><br>
                          <input type="radio" wire:model.live="minat_jurusan2" value="Akutansi">
                          <label for="">Akutansi</label><br>
                          <input type="radio" wire:model.live="minat_jurusan2" value="Pemasaran">
                          <label for="">Pemasaran</label><br>
                          <input type="radio" wire:model.live="minat_jurusan2" value="Perkantoran">
                          <label for="">Perkantoran</label><br>
                          <div class="text-danger">
                              @error('minat_jurusan2')
                                  {{ $message }}
                              @enderror
                          </div>
                      </div>
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
                    <label for="">Kelas</label>
                    <select class="form-control" wire:model.live="id_kelas">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas_ppdb as $k)
                            <option value="{{$k->id_kelas}}">{{$k->nama_kelas}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_kelas')
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


       {{-- Bayar Modal --}}
    <div class="modal fade" id="bayarppdb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
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
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" wire:click='insertppdb()'>Save changes</button>
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
                   <div class="col-lg-6">
                   <div class="form-group mb-3">
                       <label for="">Nama Lengkap</label>
                       <input type="text" wire:model.live="nama_lengkap" class="form-control">
                       <div class="text-danger">
                           @error('nama_lengkap')
                               {{$message}}
                           @enderror
                       </div>
                     </div>
                   </div>
                   <div class="col-lg-6">
                   <div class="form-group mb-3">
                       <label for="">No Hp</label>
                       <input type="text" wire:model.live="no_hp" class="form-control">
                       <div class="text-danger">
                           @error('no_hp')
                               {{$message}}
                           @enderror
                       </div>
                     </div>
                   </div>
                   <div class="col-lg-6">
                   <div class="form-group mb-3">
                       <label for="">NIS</label>
                       <input type="text" wire:model.live="nis" class="form-control">
                       <div class="text-danger">
                           @error('nis')
                               {{$message}}
                           @enderror
                       </div>
                     </div>
                   </div>
                   <div class="col-lg-6">
                     <div class="form-group mb-3">
                       <label for="">NISN</label>
                       <input type="text" wire:model.live="nisn" class="form-control">
                       <div class="text-danger">
                           @error('nisn')
                               {{$message}}
                           @enderror
                       </div>
                     </div>
                   </div>
                   <div class="col-lg-6">
                     <div class="form-group mb-3">
                       <label for="">NIK</label>
                       <input type="text" wire:model.live="nik_siswa" class="form-control">
                       <div class="text-danger">
                           @error('nik_siswa')
                               {{$message}}
                           @enderror
                       </div>
                     </div>
                     </div>
                     <div class="col-lg-6">
                     <div class="form-group mb-3">
                       <label for="">Nama Ayah</label>
                       <input type="text" wire:model.live="nama_ayah" class="form-control">
                       <div class="text-danger">
                           @error('nama_ayah')
                               {{$message}}
                           @enderror
                       </div>
                     </div>
                   </div>
                   <div class="col-lg-6">
                     <div class="form-group mb-3">
                       <label for="">Nama Ibu</label>
                       <input type="text" wire:model.live="nama_ibu" class="form-control">
                       <div class="text-danger">
                           @error('nama_ibu')
                               {{$message}}
                           @enderror
                       </div>
                   </div>
                   </div>
                   <div class="col-lg-6">
                       <div class="form-group mb-3">
                           <label for="">Asal Sekolah</label>
                           <input type="text" wire:model.live="asal_sekolah" class="form-control">
                           <div class="text-danger">
                               @error('asal_sekolah')
                                   {{$message}}
                               @enderror
                           </div>
                         </div>
                         </div>
                         <div class="col-lg-6 mb-3">
                          <div class="form-group">
                              <label for="">Minat Jurusan 1</label><br>
                              <input type="radio" wire:model.live="minat_jurusan1" value="Rekayasa Perangkat Lunak">
                              <label for="">Rekayasa Perangkat Lunak</label><br>
                              <input type="radio" wire:model.live="minat_jurusan1" value="Akutansi">
                              <label for="">Akutansi</label><br>
                              <input type="radio" wire:model.live="minat_jurusan1" value="Pemasaran">
                              <label for="">Pemasaran</label><br>
                              <input type="radio" wire:model.live="minat_jurusan1" value="Perkantoran">
                              <label for="">Perkantoran</label><br>
                              <div class="text-danger">
                                  @error('minat_jurusan')
                                      {{ $message }}
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="">Minat Jurusan 2</label><br>
                            <input type="radio" wire:model.live="minat_jurusan2" value="Rekayasa Perangkat Lunak">
                            <label for="">Rekayasa Perangkat Lunak</label><br>
                            <input type="radio" wire:model.live="minat_jurusan2" value="Akutansi">
                            <label for="">Akutansi</label><br>
                            <input type="radio" wire:model.live="minat_jurusan2" value="Pemasaran">
                            <label for="">Pemasaran</label><br>
                            <input type="radio" wire:model.live="minat_jurusan2" value="Perkantoran">
                            <label for="">Perkantoran</label><br>
                            <div class="text-danger">
                                @error('minat_jurusan')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
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
                       <label for="">Kelas</label>
                       <select class="form-control" wire:model.live="id_kelas">
                           <option value="">Pilih Kelas</option>
                           @foreach ($kelas_ppdb as $k)
                               <option value="{{$k->id_kelas}}">{{$k->nama_kelas}}</option>
                           @endforeach
                       </select>
                       <div class="text-danger">
                           @error('id_kelas')
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
              <h5 class="modal-title" id="exampleModalLabel">Reset Passwortd</h5>
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
            $('#bayarppdb').modal('hide');
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


