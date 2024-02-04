<div>
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
                              <th>Nama Buku</th>
                              <th>Tanggal Peminjam</th>
                              <th>Sudah Di Kembalikan</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                      @foreach ($data as $d)
                          <tr>
                              <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                              <td>{{$d->nama_lengkap}}</td>
                              <td>{{$d->nama_buku}}</td>
                              <td>{{date('d M Y', strtotime($d->created_at))}}</td>
                              <td>
                                @if ($d->created_at == $d->updated_at)
                                <i class="fa-solid fa-times"></i>
                                @else
                                <i class="fa-solid fa-check"></i>
                                @endif
                              </td>
                              <td>@if ($d->created_at != $d->updated_at)
                                <button disabled type="button" href="" class="btn btn-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_peminjam}}")'><i class="fa-solid fa-book"></i> Sudah Kembali</button>
                              @else
                              <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_peminjam}}")'><i class="fa-solid fa-book"></i> Kembalikan</a>
                              @endif</td>
                          </tr>
                      @endforeach
                      </tbody>
                  </table>
                   </div>
                    {{$data->links()}}
            </div>
        </div>


        {{-- Kembali Modal --}}
        <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Kembalikan Buku</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Buku</label>
                        <input type="text" wire:model.live="nama_buku" class="form-control" disabled>
                        <div class="text-danger">
                            @error('nama_buku')
                                {{$message}}
                            @enderror
                        </div>
                      </div>
                    <div class="form-group">
                        <label for="">Nama Siswa</label>
                        <input type="text" wire:model.live="nama_lengkap" class="form-control" disabled>
                        <div class="text-danger">
                            @error('nama_lengkap')
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
          <script>
            window.addEventListener('closeModal', event => {
                $('#kembali').modal('hide');
            })
            window.addEventListener('closeModal', event => {
                $('#edit').modal('hide');
            })
            window.addEventListener('closeModal', event => {
                $('#k_hapus').modal('hide');
            })
          </script>

    </div>

</div>
