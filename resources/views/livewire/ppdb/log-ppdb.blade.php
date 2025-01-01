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
                    <div class="col-6">
                        <form action="{{ route('rekapharianppdb') }}" method="get" target="_blank">
                            <div class="input-group input-group-sm mb-3">
                                <div class="col-3">
                                    <input type="date" class="form-control" name="date">
                              </div>
                                 <button class="input-group-text" id="basic-addon1">Print</button>
                                </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3">
                          <div class="col-3">
                            <select class="form-control" wire:model.live="result">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                          <div class="col-3">
                            <select class="form-control" wire:model.live="thn_ppdb">
                                <option value="">Pilih Tahun</option>
                                <option value="{{ date('Y') -1}}">{{ date('Y') -1}}</option>
                                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                <option value="{{ date('Y') +1 }}">{{ date('Y') +1 }}</option>

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
                          <th>#</th>
                          <th>Nama Siswa</th>
                          <th>Nominal</th>
                          <th>Jenis</th>
                          <th>Ket</th>
                          <th>Waktu</th>
                          @if (Auth::user()->id_role == 1)
                          <th>Aksi</th>
                          @endif
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                      <tr>
                          <td><a href="{{ route('ppdbLog', ['id_log' => $d->id_log]) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa-solid fa-print"></i></a></td>
                          <td>{{$d->nama_lengkap}}</td>
                          <td>Rp.{{number_format($d->nominal,0,',','.')}}</td>
                          <td>
                            @if ($d->jenis == 'd')
                                Daftar
                            @elseif($d->jenis == 'p')
                                PPDB
                            @else
                            Mengundurkan Diri
                            @endif</td>
                            <td>{{ substr($d->no_invoice, 2, 3) == 'TRF' ? 'Transfer' : 'Cash' }}</td>
                          <td>{{ date('d-m-Y h:i A', strtotime($d->created_at)) }}</td>
                          @if (Auth::user()->id_role == 1)
                          <td>
                            <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_log}}")'><i class="fa-solid fa-edit"></i></i></a>
                            <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_log}}')"><i class="fa-solid fa-trash"></i></a>
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
                <div class="form-group mb-3">
                    <label for="">Nama Lengkap</label>
                    <select class="form-control" wire:model="id_siswa" disabled>
                        <option value="">Pilih Siswa</option>
                        @foreach ($siswa_ppdb as $m)
                            <option value="{{ $m->id_siswa }}">{{ $m->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_siswa')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="">Nominal</label>
                    <input type="text" wire:model.live="nominal" class="form-control">
                    <div class="text-danger">
                        @error('nominal')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Jenis</label>
                    <select class="form-control" wire:model.live="jenis" disabled>
                        <option value="">Pilih Jenis</option>
                        <option value="d">Daftar</option>
                        <option value="p">PPDB</option>
                    </select>

                    <div class="text-danger">
                        @error('jenis')
                            {{ $message }}
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
      </script>

</div>


