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
                        <select wire:model.live="role" class="form-control">
                            <option value="6">Guru</option>
                            <option value="7">Tendik</option>
                        </select>
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
                            <th>Role</th>
                            <th>Hadir</th>
                            @if ($this->role == 7)
                            <th>Pulang</th>
                            @endif
                            <th>No Jadwal</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $maxHadir = 0; // Inisialisasi variabel untuk menyimpan nilai maksimal kehadiran dari semua user

                        // Menghitung total hadir, nojadwal, dan mencari kehadiran maksimal dari semua user
                        foreach ($data as $d) {
                            $hadir = App\Models\Absen::where('id_user', $d->id)->where('status', 0)->where('waktu', 'like', '%' . $this->bulan . '%')->count();
                            $pulang = App\Models\Absen::where('id_user', $d->id)->where('status', 4)->where('waktu', 'like', '%' . $this->bulan . '%')->count();
                            $nojadwal = App\Models\Absen::where('id_user', $d->id)->where('status', 1)->where('waktu', 'like', '%' . $this->bulan . '%')->count();

                            // Menghitung total kehadiran berdasarkan role
                            if ($d->nama_role == 'guru') {
                                $thadir = $hadir;
                            } else if ($d->nama_role == 'tendik') {
                                $thadir = $hadir + $pulang;
                            } else {
                                $thadir = $hadir + $nojadwal + $pulang;
                            }

                            // Memperbarui nilai kehadiran maksimal jika nilai saat ini lebih besar
                            $maxHadir = max($maxHadir, $thadir);
                        }
                        ?>
                        @foreach ($data as $d)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                            <td>{{ $d->nama_lengkap }}</td>
                            <td>{{ ucwords($d->nama_role) }}</td>
                            @php
                                $hadir = App\Models\Absen::where('id_user', $d->id)->where('status', 0)->where('waktu', 'like', '%' . $this->bulan . '%')->count();
                                $nojadwal = App\Models\Absen::where('id_user', $d->id)->where('status', 1)->where('waktu', 'like', '%' . $this->bulan . '%')->count();
                                $pulang = App\Models\Absen::where('id_user', $d->id)->where('status', 4)->where('waktu', 'like', '%' . $this->bulan . '%')->count();
                                $sakit = App\Models\Absen::where('id_user', $d->id)->where('status', 2)->where('waktu', 'like', '%' . $this->bulan . '%')->count();
                                $izin = App\Models\Absen::where('id_user', $d->id)->where('status', 3)->where('waktu', 'like', '%' . $this->bulan . '%')->count();

                                // Menghitung total kehadiran berdasarkan role
                                if ($d->nama_role == 'guru') {
                                    $thadir = $hadir;
                                } else if ($d->nama_role == 'tendik') {
                                    $thadir = $hadir + $pulang;
                                } else {
                                    $thadir = $hadir + $nojadwal + $pulang;
                                }

                                // Hitung persentase kehadiran berdasarkan nilai maksimal dari semua user
                                $persen = ($maxHadir > 0) ? ($thadir / $maxHadir) * 100 : 0;
                            @endphp
                            <td>{{ $hadir }}</td>
                            @if ($this->role == 7)
                            <td>{{ $pulang }}</td>
                            @endif
                            <td>{{ $nojadwal }}</td>
                            <td>{{ $sakit }}</td>
                            <td>{{ $izin }}</td>
                            <td>{{ round($persen, 2) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="{{ route('absenxls',['jbtn' => $this->role, 'bln' => $this->bulan]) }}" method="get">
                <div class="input-group input-group-sm mb-3">
                    <select wire:model.live="role" class="form-control">
                        <option value="6">Guru</option>
                        <option value="7">Tendik</option>
                    </select>
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
                        <button class="input-group-text" id="basic-addon1" type="submit">Print</button>
                      </div>
                    </form>
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
                    <label for="">Nama Pendek</label>
                    <input type="text" wire:model.live="nama_pendek" class="form-control">
                    <div class="text-danger">
                        @error('nama_pendek')
                            {{$message}}
                        @enderror
                    </div>
                  </div>

                <div class="form-group mb-3">
                    <label for="">No Hp</label>
                    <input type="text" wire:model.live="no_hp" class="form-control">
                    <div class="text-danger">
                        @error('no_hp')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Alamat</label>
                    <input type="text" wire:model.live="alamat" class="form-control">
                    <div class="text-danger">
                        @error('alamat')
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
                    <label for="">No Hp</label>
                    <input type="text" wire:model.live="no_hp" class="form-control">
                    <div class="text-danger">
                        @error('no_hp')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Alamat</label>
                    <input type="text" wire:model.live="alamat" class="form-control">
                    <div class="text-danger">
                        @error('alamat')
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

