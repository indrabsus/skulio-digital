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
                <div class="row justify-content-end mt-2">

                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3">
                            <div class="form-group">
                                <select class="form-control" wire:model.live="cari_kelas">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($datakelas as $k)

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
                          <th>Nama Siswa</th>
                          <th>Kelas</th>
                          <th>Pembayaran Terakhir</th>
                          <th>Bulan Lunas</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)

                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_lengkap}}</td>
                          <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                          @php
                              $last = App\Models\LogSpp::where('id_siswa', $d->id_siswa)->orderBy('created_at', 'desc')->first();
                           @endphp
                          <td>{{$last->keterangan ?? 'Belum ada pembayaran'}} - {{ $last->status ?? ''}}</td>
                          @php
                          $lunas = App\Models\LogSpp::where('id_siswa', $d->id_siswa)->where('status', 'lunas')->count();
                      @endphp
                      <td>{{ $lunas }} Bulan</td>
                          <td>
                            <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#bayar" wire:click='bayar("{{$d->id_siswa}}")'>Bayar</a>
                        </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>
               </div>
                {{$data->links()}}
        </div>
    </div>


    {{-- Edit Modal --}}
    <div class="modal fade" id="bayar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Kelas/Bulan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                    @php
                        $lst = App\Models\LogSpp::where('id_siswa', $id_siswa)->orderBy('created_at', 'desc')->limit(3)->get();
                    @endphp
                    @foreach ($lst as $l)
                    <tr>
                        <td>{{ $l->keterangan }}</td>
                        <td>{{ 'Rp.'.number_format($l->nominal,0,',','.') }}</td>

                        <td>{{ $l->status }}</td>
                    </tr>
                    @endforeach
                </table>
                <div class="form-group mb-3 mt-3">
                    <label for="">Nama Siswa</label>
                    <input type="text" wire:model.live="nama_lengkap" class="form-control" disabled>
                    <div class="text-danger">
                        @error('nama_lengkap')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Kelas</label>
                    <input type="number" wire:model.live="kelas" class="form-control">
                    <div class="text-danger">
                        @error('kelas')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Nominal</label>
                    <input type="number" wire:model.live="nominal" class="form-control">
                    <div class="text-danger">
                        @error('nominal')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  @php
                      $bln = \DB::table('master_bulan')->get();
                  @endphp
                <div class="form-group mb-3">
                    <label for="">Bulan</label>
                    <select wire:model='bulan' class="form-control">
                        <option value="">Pilih Bulan</option>
                        @foreach ($bln as $b)
                            <option value="{{ $b->kode }}">{{ $b->bulan }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('bulan')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <input type="checkbox" name="bebas" wire:model="bebas" id=""> Dibebaskan
                    <div class="text-danger">
                        @error('bebas')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='bayarspp()'>Save changes</button>
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
            $('#bayar').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#edit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#pkl').modal('hide');
        })
      </script>

</div>

