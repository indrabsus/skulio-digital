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
                          <th>Nama Siswa</th>
                          <th>Kelas</th>
                          <th>No Hp</th>
                          <th>Pembimbing</th>
                          <th>Observer</th>
                          <th>Waktu PKL</th>
                          <th>Tahun Ajaran</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                          <td>{{$d->nama_siswa}}</td>
                          <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                          <td>{{$d->no_hp}}</td>
                          <td>{{$d->nama_pembimbing}}</td>
                          <td>{{$d->nama_observer}}</td>
                          <td>{{ date('d F Y', strtotime($d->waktu_mulai)) }} - {{ date('d F Y', strtotime($d->waktu_selesai)) }}</td>
                          <td>{{$d->tahun}}</td>
                          <td> <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_pkl}}')"><i class="fa-solid fa-trash"></i></a></td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>
               </div>
                {{$data->links()}}
        </div>
    </div>


    {{-- Edit Modal --}}
    <div class="modal fade" id="pkl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Siswa</label>
                    <input type="text" wire:model.live="nama_lengkap" class="form-control" disabled>
                    <div class="text-danger">
                        @error('nama_lengkap')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mt-3">
                    <label for="">Tahun</label>
                    <input type="number" wire:model.live="tahun" class="form-control">
                    <div class="text-danger">
                        @error('tahun')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mt-3">
                    <label for="">Nama Pembimbing</label>
                    <select wire:model.live='id_pembimbing' class="form-control">
                        <option value="">Pilih Pembimbing</option>
                        @foreach ($guru as $g)
                            <option value="{{ $g->id_data }}">{{ $g->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_pembimbing')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mt-3">
                    <label for="">Nama Observer</label>
                    <select wire:model.live='id_observer' class="form-control">
                        <option value="">Pilih Observer</option>
                        @foreach ($guru as $g)
                            <option value="{{ $g->id_data }}">{{ $g->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_observer')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg">
                        <div class="form-group mt-3">
                            <label for="">Tgl Mulai PKL</label>
                            <input type="date" wire:model='waktu_mulai' class="form-control">
                            <div class="text-danger">
                                @error('waktu_mulai')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group mt-3">
                            <label for="">Tgl Selesai PKL</label>
                            <input type="date" wire:model='waktu_selesai' class="form-control">
                            <div class="text-danger">
                                @error('waktu_selesai')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='prosesPkl()'>Save changes</button>
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
            $('#pinjam').modal('hide');
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

