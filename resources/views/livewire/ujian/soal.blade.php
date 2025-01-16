<div>
    <div class="row">
        <div class="col-lg-3">
                <div class="input-group input-group-sm mb-3">
                    <div class="col-6">
                        <select name="id_kategori" class="form-control" wire:model.live="id_kategori">
                            <option value="">Pilih Kategori</option>

                            @foreach ($kategori as $k)
                                <option value="{{$k->id_kategori}}">{{$k->nama_kategori}}</option>
                            @endforeach
                        </select>
                        {{-- {{ $id_kategori }} --}}
                  </div>

                      <span class="input-group-text" id="basic-addon1">Pilih</span>
                    </div>


        </div>
        <div class="col-lg-3">
        </div>
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
                <div class="row justify-content-between mt-2">
                    @if ($id_kategori)
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#add">
                            Tambah
                          </button>
                    </div>
                    @else
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#add" disabled>
                            Tambah
                          </button>
                    </div>
                    @endif

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
               <hr>
               @foreach ($data as $d)
               <div class="mb-3 mt-3"><strong>{{ $d->nama_kategori }} - {{ $d->nama_pelajaran }}</strong></div>
               @if ($d->gambar)
               <img src="{{ asset('storage/'.$d->gambar) }}" alt="" width="300px" class="mb-3 mt-3">
               @endif

              <div class="mb-3">
                <p><td>
                    <input class="form-check-input" type="checkbox" wire:model="centang" value="{{ $d->id_soal }}"></td>
                    {{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}. {!!$d->soal!!}</p>
              </div>
              <div>
                @php
                    $option = App\Models\Opsi::where('id_soal', $d->id_soal)->get();
                @endphp
                <ol type="A">
                    @foreach ($option as $o)
                    <li>
                        @if ($o->opsi_gambar)
                        <img src="{{ asset('storage/'.$o->opsi_gambar) }}" width="200px">
                        @endif
                        {{$o->opsi}} {{ $o->benar ? '(Benar)' : '' }} <a href="" data-bs-toggle="modal" data-bs-target="#c_hapusOpsi" wire:click="c_hapusOpsi('{{$o->id_opsi}}')"><i class="fa-solid fa-times"></i></a></li>
                    @endforeach
                </ol>
              </div>

                <div>
                    <a href="" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#opsi" wire:click="c_opsi('{{$d->id_soal}}')">Masukan Opsi</a>
                    <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_soal}}")'><i class="fa-solid fa-edit"></i></i></a>
                <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_soal}}')"><i class="fa-solid fa-trash"></i></a>

                </div>
                <hr>
                            @endforeach

                <div class="mb-3 mt-3">
                    <a href="" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#c_kirimsoal" wire:click="c_soal('{{$d->id_soal ?? ''}}')">Kirim Soal</a>
                </div>
                {{$data->links()}}
                <div wire:loading.class="show-overlay" class="loading-overlay">
                    <div class="loading-text">
                        Loading data...
                    </div>
                </div>
        </div>
    </div>



    <div class="modal fade" id="opsi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <select wire:model="jml_opsi" class="form-control">
                            <option value="2">2 Opsi</option>
                            <option value="3">3 Opsi</option>
                            <option value="4">4 Opsi</option>
                            <option value="5">5 Opsi</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <input type="checkbox" wire:model.live="withImage"> Soal bergambar?
                    </div>
                    <hr>
                    @for ($i = 0; $i < $jml_opsi; $i++)
                        @if ($withImage)
                            <div class="form-group mb-3">
                                <label for="gambar">Gambar {{ $i + 1 }}</label>
                                <input type="file" class="form-control" wire:model="gambarOpsi.{{ $i }}">
                                <div class="text-danger">
                                    @error("gambarOpsi.{$i}") {{ $message }} @enderror
                                </div>
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <label for="soal">Opsi {{ $i + 1 }}</label>
                            <input type="text" class="form-control" wire:model="opsi.{{ $i }}">
                            <div class="mt-2">
                                <input type="checkbox" wire:model="benar.{{ $i }}"> Benar
                                <div class="text-danger">
                                    @error("benar.{$i}") {{ $message }} @enderror
                                </div>
                            </div>
                            <div class="text-danger">
                                @error("opsi.{$i}") {{ $message }} @enderror
                            </div>
                        </div>
                        <hr>
                    @endfor
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="insertOpsi()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="gambar">Gambar</label>
                    <input type="file" class="form-control" wire:model="gambar">
                    <div class="text-danger">
                        @error('gambar') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="soal">Soal</label>
                    <textarea id="soal" cols="30" rows="10" class="form-control" wire:model="soal"></textarea>
                    <div class="text-danger">
                        @error('soal') {{$message}} @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" wire:click="insert">Save changes</button>
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
                <div>
                    <img src="{{asset('storage/'.$gambar2)}}" alt="" style="width: 100px">
                </div>
                <div class="form-group mb-3">
                    <label for="gambar">Gambar</label>
                    <input type="file" class="form-control" wire:model="gambar">
                    <div class="text-danger">
                        @error('gambar') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="soal">Soal</label>
                    <textarea id="soal" cols="30" rows="10" class="form-control" wire:model="soal"></textarea>
                    <div class="text-danger">
                        @error('soal') {{$message}} @enderror
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

    <div class="modal fade" id="c_kirimsoal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tampung Soal</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select class="form-control" wire:model="id_soalujian">
                        <option value="">Pilih Kategori</option>
                        @foreach ($soalujian as $s)
                            <option value="{{ $s->id_soalujian }}">{{ $s->nama_soal }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_soalujian') {{$message}} @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='kirimSoal()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>



    <div class="modal fade" id="c_hapusOpsi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Hapus data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin menghapus data ini?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='hapusOpsi()'>Save changes</button>
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
            $('#c_sumatif').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#c_kirimsoal').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#opsi').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#c_hapusOpsi').modal('hide');
        })
      </script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('soal');

    textarea.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const cursorPos = textarea.selectionStart;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos);
            textarea.value = textBefore + '<br>\n' + textAfter;
            textarea.selectionEnd = cursorPos + 5; // Position the cursor after the newline
        }
    });
});

        </script>


</div>

