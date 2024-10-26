<div>
    <div class="row justify-content-between">
        <div class="col-lg-8">
            <div class="input-group input-group-sm mb-3">
                <select class="form-control" wire:model.live="kelas">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas2 as $z)
                        <option value="{{$z->id_kelas}}">{{$z->tingkat.' '.$z->singkatan.' '.$z->nama_kelas}}</option>
                    @endforeach
                </select>
                <select wire:model.live="carisemester" class="form-control">
                    <option value="">Semua</option>
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                </select>
                <select wire:model.live="caritahun" class="form-control">
                    <option value="">Pilih Tahun</option>
                    <option value="{{ date('Y') -1}}">{{ date('Y') -1}}</option>
            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
            <option value="{{ date('Y') +1}}">{{ date('Y') +1}}</option>
                </select>
              <div class="col-4">
                <select class="form-control" wire:model.live="result">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="300">300</option>
                </select>
            </div>
                <input type="text" class="form-control" placeholder="Cari..." aria-label="Username" aria-describedby="basic-addon1" wire:model.live="cari">
                <span class="input-group-text" id="basic-addon1">Cari</span>
              </div>
        </div>
        @if (Auth::user()->id_role == 1)

        <div class="col-lg-2">

                <div class="input-group input-group-sm mb-3">
                        <select class="form-control" wire:model.live="bulan">
                            <option value="">Pilih Bulan</option>
                            <option value="{{ date('Y') }}-01">Januari {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-02">Februari {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-03">Maret {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-04">April {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-05">Mei {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-06">Juni {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-07">Juli {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-08">Agustus {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-09">September {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-10">Oktober {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-11">November {{ date('Y') }}</option>
                            <option value="{{ date('Y') }}-12">Desember {{ date('Y') }}</option>
                        </select>
                        <a href="{{ route('agendaguru',['bulan' => $this->bulan ?? '']) }}" class="input-group-text" id="basic-addon1" type="submit">Print</a>
                      </div>

        </div>
        <div class="col-lg-2">
            <form action="{{ route('rekapharianagenda') }}" method="post" target="_blank">
                <div class="input-group input-group-sm mb-3">

                        <input type="date" class="form-control" name="date">

                     <button class="input-group-text" id="basic-addon1">Print</button>
                    </div>
            </form>
        </div>
        @endif
    </div>
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
               <div class="table-responsive">
                <table class="table table-stripped">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Materi</th>
                          @if (Auth::user()->id_role != 6)
                          <th>Nama Guru</th>
                          @endif
                          <th>Kelas</th>
                          <th>Mapel</th>
                          <th>Tahun/Semester</th>
                          <th>Tanggal</th>
                          @if (Auth::user()->id_role != 5)
                          <th>Penilaian</th>
                          @endif
                          @if (Auth::user()->id_role == 1)
                          <th>Keterangan</th>
                          <th>Aksi</th>
                          @endif
                          {{-- <th>Aksi</th> --}}
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->materi}}</td>
                          @if (Auth::user()->id_role != 6)
                          <td>{{ $d->nama_lengkap }}</td>
                          @endif
                          <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                          <td>{{$d->nama_pelajaran}}</td>
                          <td>{{ strtoupper($d->tingkatan).' '.$d->tahun.'/'.$d->semester }}</td>
                          <td>{{ date('d F Y', strtotime($d->created_at)) }}</td>
                          @if (Auth::user()->id_role != 5)
                          <td>@if ($d->penilaian == 'y')
                            <button class="btn btn-success btn-sm" wire:click="nilaisiswa('{{ $d->id_materi }}')"><i class="fa-solid fa-check"></i></button>
                          @else
                          <button class="btn btn-primary btn-sm" wire:click="nilaisiswa('{{ $d->id_materi }}')"><i class="fa-solid fa-times"></i></button>
                          @endif</td>
                          @endif
                          @if (Auth::user()->id_role == 1)
                          <td>
                            @if ($d->materi == 'Tidak Mengisi AGENDA!')
                                -
                            @else
                                @if ($d->keterangan == 1)
                                Hadir
                                @elseif($d->keterangan == 2)
                                Tidak Hadir (Penugasan)
                                @elseif($d->keterangan == 3)
                                Tidak Hadir (Tanpa Keterangan)
                                @else
                                Belum dikonfirmasi
                                @endif
                            @endif

                          </td>
                          @endif
                          <td>
                                @if(Auth::user()->id_role == 1)
                                <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_materi}}")'><i class="fa-solid fa-edit"></i></i></a>
                                <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_materi}}')"><i class="fa-solid fa-trash"></i></a>
                                @endif
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>
               </div>
                {{$data->links()}}
                <div wire:loading.class="show-overlay" class="loading-overlay">
                    <div class="loading-text">
                        Loading data...
                    </div>
                </div>
        </div>
    </div>


    @if (Auth::user()->id_role == 5)
{{-- Add Modal --}}
<div class="modal fade" id="addagenda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            {{-- <div class="form-group mb-3">
                <label for="">Semester</label>
                <select wire:model.live="semester" class="form-control">
                    <option value="">Pilih Semester</option>
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                </select>
                <div class="text-danger">
                    @error('semester')
                        {{$message}}
                    @enderror
                </div>
              </div> --}}

            <div class="form-group mb-3">
                <label for="">Mapel Kelas</label>
                <select wire:model.live="id_mapelkelas" class="form-control">
                    <option value="">Pilih Opsi</option>
                    @foreach ($mapelv as $mv)
                        <option value="{{ $mv->id_mapelkelas }}">{{ $mv->nama_lengkap }} : {{ $mv->nama_pelajaran }} - {{ $mv->tingkat.' '.$mv->singkatan.' '.$mv->nama_kelas.' - '.$mv->tahun }}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_mapelkelas')
                        {{$message}}
                    @enderror
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" wire:click='insertagenda()'>Save changes</button>
        </div>
      </div>
    </div>
  </div>
    @endif


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
                    <label for="">Materi</label>
                    <input type="text" wire:model.live="materi" class="form-control">
                    <div class="text-danger">
                        @error('materi')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Tingkat</label>
                    <select class="form-control" wire:model.live="tingkatan">
                        <option value="">Materi Kelas</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <div class="text-danger">
                        @error('tingkatan')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                {{-- <div class="form-group mb-3">
                    <label for="">Semester</label>
                    <select wire:model.live="semester" class="form-control">
                        <option value="">Pilih Semester</option>
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                    <div class="text-danger">
                        @error('semester')
                            {{$message}}
                        @enderror
                    </div>
                  </div> --}}

                <div class="form-group mb-3">
                    <label for="">Mapel Kelas</label>
                    <select wire:model.live="id_mapelkelas" class="form-control">
                        <option value="">Pilih Opsi</option>
                        @foreach ($mapelkelas as $m)
                            <option value="{{ $m->id_mapelkelas }}">{{ $m->nama_pelajaran }} - {{ $m->tingkat.' '.$m->singkatan.' '.$m->nama_kelas.' - '.$m->tahun }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_mapelkelas')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Penilaian</label>
                    <select class="form-control" wire:model.live="penilaian">
                        <option value="">Pilih Opsi</option>
                        <option value="y">Ya</option>
                        <option value="n">Tidak</option>
                    </select>
                    <div class="text-danger">
                        @error('penilaian')
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
                    <label for="">Materi</label>
                    <input type="text" wire:model.live="materi" class="form-control">
                    <div class="text-danger">
                        @error('materi')
                            {{$message}}
                        @enderror
                    </div>
                  </div>

                  <div class="form-group mb-3">
                    <label for="">Keterangan</label>
                    <select class="form-control" wire:model.live="keterangan">
                        <option value="">Pilih Opsi</option>
                        <option value="1">Hadir</option>
                        <option value="2">Penugasan</option>
                        <option value="3">Tanpa Keterangan</option>
                    </select>
                    <div class="text-danger">
                        @error('keterangan')
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
            $('#konf').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#addagenda').modal('hide');
        })
      </script>

</div>

