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
                          <th>Jumlah Agenda/terisi</th>
                          <th>Presentasi Mengisi Agenda</th>
                          {{-- <th>Hadir dikelas</th>
                          <th>Izin/Penugasan</th>
                          <th>Tidak Hadir Tanpa Keterangan</th>
                          <th>Belum dikonfirmasi</th> --}}

                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}
                        </td>
                          <td>{{$d->nama_lengkap}} @if ($d->no_rfid)
                            <i class="fa-solid fa-check">
                            @endif</td>
                            @php
                                $jmlagenda = App\Models\Materi::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
                                ->where('mapel_kelas.id_user', $d->id_user)
                                ->where('materi.created_at', 'like','%'.$this->bulan.'%')
                                ->count();
                                $agendaterisi = App\Models\Materi::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
                                ->where('mapel_kelas.id_user', $d->id_user)
                                ->where('materi.materi', '!=', 'Tidak Mengisi AGENDA!')
                                ->where('materi.created_at', 'like','%'.$this->bulan.'%')
                                ->count();
                            @endphp
                        <td>{{ $jmlagenda }}/{{ $agendaterisi }}</td>
                        <td>{{ $jmlagenda == 0 ? 0 : round($agendaterisi / $jmlagenda * 100, 0) }} %</td>
                        @php
                        $jml = App\Models\Materi::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
                                ->where('mapel_kelas.id_user', $d->id_user)
                                ->where('materi.created_at', 'like','%'.$this->bulan.'%')
                                ->count();
                            $hadirdikelas = $jmlagenda = App\Models\Materi::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
                                ->where('mapel_kelas.id_user', $d->id_user)
                                ->where('materi.created_at', 'like','%'.$this->bulan.'%')
                                ->where('keterangan', 1)
                                ->count();
                            $izin = App\Models\Materi::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
                                ->where('mapel_kelas.id_user', $d->id_user)
                                ->where('materi.created_at', 'like','%'.$this->bulan.'%')
                                ->where('keterangan', 2)
                                ->count();
                            $alfa = App\Models\Materi::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
                                ->where('mapel_kelas.id_user', $d->id_user)
                                ->where('materi.created_at', 'like','%'.$this->bulan.'%')
                                ->where('keterangan', 3)
                                ->count();
                            $nc = App\Models\Materi::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
                                ->where('mapel_kelas.id_user', $d->id_user)
                                ->where('materi.created_at', 'like','%'.$this->bulan.'%')
                                ->where('keterangan', null)
                                ->count();
                        @endphp
                        {{-- <td>{{ $jml == 0 ? 0 : round($hadirdikelas / $jml * 100, 0) }} %</td>
                        <td>{{ $jml == 0 ? 0 : round($izin / $jml * 100, 0) }} %</td>
                        <td>{{ $jml == 0 ? 0 : round($alfa / $jml * 100, 0) }} %</td>
                        <td>{{ $jml == 0 ? 0 : round($nc / $jml * 100, 0) }} %</td> --}}


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
                    <label for="">Nama Lengkap</label>
                    <input type="text" wire:model.live="nama_lengkap" class="form-control">
                    <div class="text-danger">
                        @error('nama_lengkap')
                            {{$message}}
                        @enderror
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
                    <label for="">Role</label>
                    <select class="form-control" wire:model.live="id_role">
                        <option value="">Pilih Role</option>
                        <option value="6">Guru</option>
                        <option value="7">Tendik</option>
                    </select>
                    <div class="text-danger">
                        @error('id_role')
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
                    <label for="">Nama Lengkap</label>
                    <input type="text" wire:model.live="nama_lengkap" class="form-control">
                    <div class="text-danger">
                        @error('nama_lengkap')
                            {{$message}}
                        @enderror
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
                    <label for="">Role</label>
                    <select class="form-control" wire:model.live="id_role">
                        <option value="">Pilih Role</option>
                        <option value="6">Guru</option>
                        <option value="7">Tendik</option>
                    </select>
                    <div class="text-danger">
                        @error('id_role')
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
              <h5 class="modal-title" id="exampleModalLabel">Reset Passwort</h5>
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

