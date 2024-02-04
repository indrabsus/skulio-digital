<div>
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
      @if (Auth::user()->id_role == 1 || Auth::user()->id_role == 2)
      <div class="row justify-content-between">
        <div class="col-lg-2 mb-3">
            <button class="btn btn-outline-success btn-sm" wire:click="allow()"><i class="fa-solid fa-check"></i> Allow All</button>
        </div>
        <div class="col-lg-2 mb-3">
            <button class="btn btn-outline-danger btn-sm" wire:click="disallow()"><i class="fa-solid fa-times"></i> Disallow All</button>
        </div>
    </div>
    @endif
      <div class="row justify-content-between mt-2">
        <div class="col-lg-6">
          @if (Auth::user()->id_role == 1 || Auth::user()->id_role == 2)
            <button type="button" class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#add">
                Tambah
              </button>

              @endif
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
    @if(Session::get('id_ujian'))
    @php
    $ujian = App\Models\Ujian::where('id_ujian', Session::get('id_ujian'))->first()
    @endphp
    <h3>Sesi : {{$ujian->nama_ujian}} - <a href="{{route('test')}}" class="btn btn-outline-primary btn-sm">Lanjutkan</a></h3>
    @endif
    <div class="table-responsive">
        <table class="table table-responsive">
            <tr>
                <th>No</th>
                <th>Nama Test</th>
                <th>Waktu</th>
                <th>Kelas</th>
                @if (Auth::user()->id_role == 1 || Auth::user()->id_role == 2)
                <th>Token</th>
                <th>Publish</th>
                <th>Aksi</th>

                @endif
                @if (Auth::user()->id_role == 8)
                <th>Ujian</th>
                @endif
            </tr>

            @foreach ($data as $d)
            @php
                $us = App\Models\DataSiswa::where('id_user',Auth::user()->id)->first();
                if($us){
                $logi = App\Models\LogUjian::where('id_ujian',$d->id_ujian)->where('id_siswa', $us->id_siswa)->first();
                $count = App\Models\LogUjian::where('status', 'done')->where('id_siswa',$us->id_siswa)
                ->where('id_ujian', $d->id_ujian)
                ->count();
            }

            @endphp
                <tr>
                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                    <td>@if (Auth::user()->id_role == 8)
                        {{ $d->nama_ujian }}
                    @else
                    <a href="{{$d->link}}" target="_blank">{{ $d->nama_ujian }}</a>
                    @endif</td>
                    <td>{{ $d->waktu }} Menit</td>
                    <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                    @if (Auth::user()->id_role == 1 || Auth::user()->id_role == 2)
                    <td>{{$d->token}}</td>
                    <td>

                        @if ($d->acc == 'y')
                      <i class="fa fa-check" aria-hidden="true"></i>
                    @else
                    <i class="fa fa-times" aria-hidden="true"></i>
                    @endif</td>
                    <td>
                        <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_ujian}}")'><i class="fa-solid fa-edit"></i></a>
                        <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_ujian}}')"><i class="fa-solid fa-trash"></i></a>
                      </td>
                      @endif
                      @if (Auth::user()->id_role == 8)
                      <td>

                        @if(Session::get('id_ujian'))
                        <button class="btn btn-outline-primary" disabled><i class="fa fa-times" aria-hidden="true"></i></button>
                        @elseif($count < 1)
                        <a href="{{route('token',['id' => $d->id_ujian])}}" class="btn btn-outline-primary btn-sm">Mulai</a>
                        @else
                        <button class="btn btn-outline-primary" disabled>Berakhir</button>
                        @endif
                       </td>
                      @endif
                </tr>
            @endforeach
        </table>
    </div>

            {{ $data->links() }}


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
                  <label for="">Nama Test</label>
                  <input type="text" wire:model="nama_ujian" class="form-control">
                  <div class="text-danger">
                      @error('nama_ujian')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Waktu (Menit)</label>
                  <input type="number" wire:model="waktu" class="form-control">
                  <div class="text-danger">
                      @error('waktu')
                          {{$message}}
                      @enderror
                  </div>
                </div>

                <div class="form-group mb-3">
                  <label for="">Pilih Kelas</label>
                  @foreach ($kelas as $k)
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


                <div class="form-group">
                  <label for="">Link Google Form</label>
                  <input type="text" wire:model="link" class="form-control">
                  <div class="text-danger">
                      @error('link')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Token</label>
                  <input type="number" wire:model="token" class="form-control">
                  <div class="text-danger">
                      @error('token')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Publish</label>
                  <select wire:model="acc" class="form-control">
                      <option value="">Publish?</option>
                      <option value="y">Ya</option>
                      <option value="n">Tidak</option>
                  </select>
                  <div class="text-danger">
                      @error('acc')
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



    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                   Kelas: {{ $kelasedit }}
                </div>
                <div class="form-group">
                  <label for="">Nama Test</label>
                  <input type="text" wire:model="nama_ujian" class="form-control">
                  <div class="text-danger">
                      @error('nama_ujian')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Waktu (Menit)</label>
                  <input type="number" wire:model="waktu" class="form-control">
                  <div class="text-danger">
                      @error('waktu')
                          {{$message}}
                      @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label for="">Link Google Form</label>
                  <input type="text" wire:model="link" class="form-control">
                  <div class="text-danger">
                      @error('link')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Token</label>
                  <input type="number" wire:model="token" class="form-control">
                  <div class="text-danger">
                      @error('token')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Publish</label>
                  <select wire:model="acc" class="form-control">
                      <option value="">Publish?</option>
                      <option value="y">Ya</option>
                      <option value="n">Tidak</option>
                  </select>
                  <div class="text-danger">
                      @error('acc')
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
            $('#k_bayar').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#req').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#hs').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#da').modal('hide');
        })
      </script>

</div>
