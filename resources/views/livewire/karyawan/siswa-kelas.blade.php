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

                    <div class="col-lg-12">
                        <div class="input-group input-group-sm mb-3">
                            <select wire:model.live="caritahun" class="form-control">
                                <option value="">Pilih Tahun</option>
                                <option value="{{ date('Y') -1}}">{{ date('Y') -1}}</option>
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option value="{{ date('Y') +1}}">{{ date('Y') +1}}</option>
                            </select>
                                <select class="form-control" wire:model.live="cari_kelas">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                    <option value="{{$k->id_kelas}}">{{$k->tingkat.' '.$k->singkatan.' '.$k->nama_kelas}}</option>
                                    @endforeach
                                </select>
                                <select wire:model.live="id_materi" class="form-control">
                                    <option value="">Pilih Materi</option>
                                    @foreach ($materi as $m)
                                        <option value="{{$m->id_materi}}">{{ $m->materi }}</option>
                                    @endforeach
                                </select>

                          <div class="col-3">
                            <select class="form-control" wire:model.live="result">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                            <input type="text" class="form-control" placeholder="Cari Nama/Materi" aria-label="Username" aria-describedby="basic-addon1" wire:model.live="cari">
                            <span class="input-group-text" id="basic-addon1">Cari</span>
                          </div>
                    </div>
                </div>
               <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                      <tr>

                          <th>No</th>
                          <th>Nama Lengkap</th>
                          <th>Kelas</th>
                          <th>Tanggal</th>
                          <th>Absen</th>
                          <th>Materi</th>
                          <th>Nilai</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_lengkap}}</td>
                          <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                          <td>{{ date('d F Y', strtotime($d->waktu_agenda)) }}</td>
                          @php
                              $abs = App\Models\AbsenSiswa::where('id_user', $d->id_user)
                              ->where('waktu', 'like','%'.date('Y-m-d',strtotime($d->waktu_agenda)).'%')
                              ->where('id_materi', $d->id_materi)
                              ->first();
                              $status = 'Hadir';
                              if(isset($abs)){
                                if($abs->keterangan == 1){
                                $status = 'Terlambat';
                              } elseif($abs->keterangan == 2){
                                $status = 'Sakit';
                              } elseif($abs->keterangan == 3){
                                $status = 'Izin';
                              } elseif($abs->keterangan == 4){
                                $status = 'Tanpa Keterangan';
                              } else {
                                $status = 'Dispen';
                              }
                              }
                          @endphp

                          @if ($abs == null)
                          <td><a href="" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#cabsen" wire:click="cabsen('{{ $d->id_user }}', '{{ $d->id_materi }}', '{{ $d->waktu_agenda }}' )">Hadir</a></td>

                          @else
                          <td>
                            {{ $d->id_absen }}
                            <a href="" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#a_cancel" wire:click="a_cancel('{{ $d->id_user }}', '{{ $d->id_materi }}')">{{ $status }}</a></td>

                          @endif
                          <td>{{ $d->materi }}</td>
                           @php
                              $nil = App\Models\Nilai::where('nilai.id_materi', $d->id_materi)
                              ->where('nilai.id_user', $d->id_user)->first();
                          @endphp
                          @if ($nil != null)
                          <td><a href="" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="chapus('{{ $nil->id }}')">{{ $nil->nilai }}</a></td>
                         @else
                         @if ($d->penilaian == "y")
                         <td><a href="" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#tugas" wire:click="tugas('{{ $d->id_materi }}','{{ $d->id_user }}')">Beri Nilai</a></td>
                         @else
                         <td><span class="badge bg-dark" data-bs-toggle="modal">Nilai Disabled</span></td>
                         @endif

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
    <div class="modal fade" id="tugas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                  <div class="form-group mb-3">
                    <label for="">Nilai</label>
                    <input type="number" class="form-control" wire:model.live="nilai">
                    <div class="text-danger">
                        @error('nilai')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  {{-- <div class="form-group mb-3">
                    <label for="">URL</label>
                    <input type="text" class="form-control" wire:model.live="extra">
                    <div class="text-danger">
                        @error('extra')
                            {{$message}}
                        @enderror
                    </div>
                  </div> --}}
                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='kirimnilai()'>Save changes</button>
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
    {{-- Delete Modal --}}
    <div class="modal fade" id="a_cancel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin menghapus data ini?
                {{ $id_user }}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='a_delete()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="cabsen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Absen Siswa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="">Keterangan</label>
                    <select wire:model="keterangan" class="form-control" wire:model.live="keterangan">
                        <option value="">Pilih Keterangan</option>
                        <option value="1">Terlambat</option>
                        <option value="2">Sakit</option>
                        <option value="3">Izin</option>
                        <option value="4">Tanpa Keterangan</option>
                        <option value="5">Dispen</option>
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
              <button type="button" class="btn btn-primary" wire:click='absen()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>


      <script>
        window.addEventListener('closeModal', event => {
            $('#tugas').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#cabsen').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_reset').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#a_cancel').modal('hide');
        })
      </script>

</div>

