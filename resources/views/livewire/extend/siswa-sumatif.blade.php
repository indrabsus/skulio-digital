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
                          <div class="col-3">
                            <select class="form-control" wire:model.live="result">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                            <input type="text" class="form-control" placeholder="Cari Nama" aria-label="Username" aria-describedby="basic-addon1" wire:model.live="cari">
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
                          <th>Mata Pelajaran</th>
                          <th>Tingkat/Tahun Pelajaran</th>
                          <th>Nilai Sumatif</th>
                          <th>Jawaban</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_lengkap}}</td>
                          <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                          @php
                          $ts = App\Models\Sumatif::leftJoin('mapel_kelas', 'mapel_kelas.id_mapelkelas', 'sumatif.id_mapelkelas')
                          ->leftJoin('mata_pelajaran', 'mata_pelajaran.id_mapel', 'mapel_kelas.id_mapel')
                          ->leftJoin('kelas', 'kelas.id_kelas', 'mapel_kelas.id_kelas')
                        //   ->where('id_user', $d->id)
                          ->where('id_sumatif', $this->id_sumatif)
                          ->first();
                      @endphp
                          <td>{{ $ts->nama_pelajaran ?? ''}}</td>

                          <td> {{ $ts->tingkat ?? '' }}/{{ $ts->tahun ?? '' }}</td>
                          @php

                              $sum = App\Models\NilaiUjian::leftJoin('sumatif', 'sumatif.id_sumatif','nilai_ujian.id_sumatif')
                              ->where('id_user_siswa', $d->id)
                              ->where('sumatif.id_sumatif', $this->id_sumatif)
                              ->first();

                          @endphp
                          <td>{{ $exam->hitungNilai($this->id_sumatif, $d->id) }}</td>
                          <td>
                            @if ($sum && $sum->id_nilaiujian)
                                <a href="{{ route('pratinjau', ['id_nilaiujian' => $sum->id_nilaiujian]) }}" target="_blank" class="btn btn-primary btn-sm">Lihat</a>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_hapus('{{ $sum->id_nilaiujian }}')">
                                    Reset
                                  </button>
                                @else
                                Belum Mengerjakan
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
      </script>

</div>

