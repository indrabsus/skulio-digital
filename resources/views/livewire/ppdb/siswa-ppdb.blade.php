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
                        <div class="input-group input-group-sm mb-3">
                          <div class="col-3">
                            <select class="form-control" wire:model.live="filter">
                                <option value="all">Semua</option>
                                <option value="y">Sudah Bayar</option>
                                <option value="n">Belum Bayar</option>
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
                          <th>Nama Lengkap</th>
                          <th>No Hp</th>
                          <th>Asal Sekolah</th>
                          <th>NISN</th>
                          <th>Kelas</th>
                          <th>Nominal</th>
                          <th>Kelola</th>
                          @if (Auth::user()->id_role == 1)
                          <th>Aksi</th>
                          @endif
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_lengkap}} {{ $d->bayar_daftar == 'l' ? ' - Mengundurkan Diri' : '' }}</td>
                          <td>{{$d->no_hp}}</td>
                          <td>{{$d->asal_sekolah}}</td>
                          <td>{{$d->nisn}}</td>
                          <td>
                            @php
                                $kelas = App\Models\SiswaBaru::leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')->where('id_siswa', $d->id_siswa)->first();

                            @endphp
                            @if ($kelas == NULL)
                                 -
                            @else
                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#c_hkelas" wire:click="c_hkelas('{{ $d->id_siswa }}')">{{ $kelas->nama_kelas }}</button>
                            @endif
                          </td>
                          <td>
                            @php
                                $log = App\Models\LogPpdb::where('id_siswa', $d->id_siswa)
                                ->where('jenis','p')
                                ->sum('nominal');
                            @endphp
                            Rp.{{ number_format($log,0,',','.') }}
                          </td>
                          <td>@if ($d->bayar_daftar == 'y')
                            <button class="btn btn-outline-success btn-sm" disabled><i class="fa-solid fa-check"></i></button>
                            @else
                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#kdaftar" wire:click="kdaftar('{{ $d->id_siswa }}')"><i class="fa-solid fa-times"></i></button>
                            @endif


                            @if ($d->bayar_daftar == 'y')
                            <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#bayarppdb" wire:click="ppdb('{{ $d->id_siswa }}')"><i class="fa-solid fa-wallet"></i></button>
                            @else
                            <button disabled class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-wallet"></i></button>
                        @endif
                            <a href="" class="btn btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#ckelas" wire:click='ckelas("{{$d->id_siswa}}")'><i class="fa-solid fa-share"></i></a>
                        </td>
                        @if (Auth::user()->id_role == 1)
                          <td>
                              <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_siswa}}")'><i class="fa-solid fa-edit"></i></a>
                              <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_siswa}}')"><i class="fa-solid fa-trash"></i></a>
                              <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#c_undur" wire:click='c_undur("{{$d->id_siswa}}")'><i class="fa-solid fa-share"></i></a>
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
                   <div class="col-lg">
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
                         <div class="col-lg-6 mb-3">
                            <div class="form-group">
                                <label for="">Minat Jurusan 1</label><br>

                                @foreach ($jurusan as $j)
                                <input type="radio" wire:model.live="minat_jurusan1" value="{{ $j->nama_jurusan }}">
                                <label for="">{{ $j->nama_jurusan }}</label><br>
                                @endforeach
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

                                @foreach ($jurusan as $j)
                                <input type="radio" wire:model.live="minat_jurusan2" value="{{ $j->nama_jurusan }}">
                                <label for="">{{ $j->nama_jurusan }}</label><br>
                                @endforeach
                                <div class="text-danger">
                                    @error('minat_jurusan2')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
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


       {{-- Daftar Modal --}}
    <div class="modal fade" id="kdaftar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Daftar</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="">Jenis Pembayaran</label>
                    <select wire:model.live='jenis' class="form-control">
                        <option value="">Pilih Jenis Pembayaran</option>
                        <option value="csh">Tunai</option>
                        <option value="trf">Transfer</option>
                    </select>
                    <div class="text-danger">
                        @error('jenis')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='daftar()'>Save changes</button>
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


    <div class="modal fade" id="c_undur" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Undur Diri</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah siswa ini mengundurkan diri?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='mengundurkandiri()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>


    <div class="modal fade" id="c_hkelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Undur Diri</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Hapus kelas?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='hapusKelas()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="bayarppdb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Bayar PPDB</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Anda sudah membayar Rp. {{ number_format($nom,0,',','.') }}</p>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="">Nominal</label>
                        <input type="text" class="form-control" wire:model.live="nom2">
                        Rp. {{ number_format(floatval($nom2),0,',','.') }}
                        <div class="text-danger">
                            @error('nom2')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="">Jenis Pembayaran</label>
                    <select wire:model.live='jenis' class="form-control">
                        <option value="">Pilih Jenis Pembayaran</option>
                        <option value="csh">Tunai</option>
                        <option value="trf">Transfer</option>
                    </select>
                    <div class="text-danger">
                        @error('jenis')
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



      <div class="modal fade" id="ckelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Kelas PPDB</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <p>Minat 1 : {{ $minat_jurusan1 }}</p>
                    <p>Minat 2 : {{ $minat_jurusan2 }}</p>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="">Pilih Kelas</label>
                        <select class="form-control" wire:model="kelas">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas_ppdb as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">
                            @error('kelas')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='insertkelas()'>Save changes</button>
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
            $('#bayarppdb').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#ckelas').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#c_undur').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#c_hkelas').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#kdaftar').modal('hide');
        })
      </script>

</div>


