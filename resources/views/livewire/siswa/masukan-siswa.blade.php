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
                          <th>Masukan</th>
                          <th>Kategori</th>
                          {{-- <th>foto</th> --}}

                          <th>Status</th>
                          @if (Auth::user()->id_role == 1)
                          <th>Aksi</th>
                          @endif
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                  <tr>
                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                    <td>
                       {{ $d->masukan }}
                    </td>
                    <td>{{ $this->kategori($d->kategori) }}</td>
                    {{-- <td>@if ($d->gambar)
                        <a href="" data-bs-toggle="modal" data-bs-target="#lihat" wire:click='lihat("{{$d->id_masukan}}")'>View Image</a>
                        @else
                        No Image
                        @endif</td> --}}
                    <td>
                        @if (Auth::user()->id_role == 1)
                        @if ($d->status == '0')
                        <button wire:click="c_status('{{$d->id_masukan}}')" class="badge bg-warning">Menunggu</button>
                            @elseif($d->status == '1')
                                <button wire:click="c_status('{{$d->id_masukan}}')" class="badge bg-primary">Diproses</button>
                            @else
                                <button wire:click="c_status('{{$d->id_masukan}}')" class="badge bg-success">Selesai</button>
                        @endif
                        @else
                        @if ($d->status == '0')
                        <span class="badge bg-warning">Menunggu</span>
                            @elseif($d->status == '1')
                                <span class="badge bg-primary">Diproses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                        @endif
                        @endif
                    </td>
                    @if (Auth::user()->id_role == 1)
                    <td>
                        <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_masukan}}')"><i class="fa-solid fa-trash"></i></a>
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
                    <label for="">Masukan</label>
                    <textarea wire:model="masukan" class="form-control" cols="30" rows="10"></textarea>
                    <div class="text-danger">
                        @error('masukan')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <label for="">Kategori</label>
                    <select wire:model="kategori" class="form-control">
                        <option value="">Pilih Kategori</option>
                        <option value="sarpras">Fasilitas Sekolah</option>
                        <option value="guru">Kualitas Pengajaran</option>
                        <option value="bk">Layanan Bimbingan Konseling</option>
                        <option value="perpustakaan">Manajemen Perpustakaan</option>
                        <option value="keamanan">Keamanan Sekolah</option>
                        <option value="lain">Layanan Umum</option>
                    </select>
                    <div class="text-danger">
                        @error('kategori')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group mb-3">
                    <input type="file" wire:model="gambar" class="form-control">
                    <i>Jika tidak ada foto, dikosongkan saja!</i>
                    <div class="text-danger">
                        @error('gambar')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div>
                    <input type="checkbox" wire:model="anonim"> Anonim?
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
                <div class="form-group">
                    <label for="">Nama Buku</label>
                    <input type="text" wire:model.live="nama_buku" class="form-control">
                    <div class="text-danger">
                        @error('nama_buku')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                <div class="form-group">
                    <label for="">Link Buku</label>
                    <input type="text" wire:model.live="link_buku" class="form-control">
                    <div class="text-danger">
                        @error('link_buku')
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
    <div class="modal fade" id="lihat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Lihat</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/'.$this->gambar2) }}" width="100%">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

