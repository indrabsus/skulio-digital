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
               <p>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}. {!!$d->soal!!}</p>
                <ol type="a">
                    <li>{{ $d->pilihan_a }} {{ $d->pilihan_a == $d->{$d->jawaban} ? '(Jawaban)' : ''}}</li>
                    <li>{{ $d->pilihan_b }} {{ $d->pilihan_b == $d->{$d->jawaban} ? '(Jawaban)' : ''}}</li>
                    <li>{{ $d->pilihan_c }} {{ $d->pilihan_c == $d->{$d->jawaban} ? '(Jawaban)' : ''}}</li>
                    <li>{{ $d->pilihan_d }} {{ $d->pilihan_d == $d->{$d->jawaban} ? '(Jawaban)' : ''}}</li>
                    <li>{{ $d->pilihan_e }} {{ $d->pilihan_e == $d->{$d->jawaban} ? '(Jawaban)' : ''}}</li>
                </ol>
                <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_soal}}")'><i class="fa-solid fa-edit"></i></i></a>
                <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_soal}}')"><i class="fa-solid fa-trash"></i></a>
                <hr>
                            @endforeach
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

                <div class="form-group mb-3">
                    <label for="pilihan_a">Pilihan A</label>
                    <input type="text" class="form-control" wire:model="pilihan_a">
                    <div class="text-danger">
                        @error('pilihan_a') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="pilihan_b">Pilihan B</label>
                    <input type="text" class="form-control" wire:model="pilihan_b">
                    <div class="text-danger">
                        @error('pilihan_b') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="pilihan_c">Pilihan C</label>
                    <input type="text" class="form-control" wire:model="pilihan_c">
                    <div class="text-danger">
                        @error('pilihan_c') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="pilihan_d">Pilihan D</label>
                    <input type="text" class="form-control" wire:model="pilihan_d">
                    <div class="text-danger">
                        @error('pilihan_d') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="pilihan_e">Pilihan E</label>
                    <input type="text" class="form-control" wire:model="pilihan_e">
                    <div class="text-danger">
                        @error('pilihan_e') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="jawaban">Kunci Jawaban</label>
                    <select wire:model="jawaban" class="form-control">
                        <option value="">Pilih Kunci Jawaban</option>
                        <option value="pilihan_a">A</option>
                        <option value="pilihan_b">B</option>
                        <option value="pilihan_c">C</option>
                        <option value="pilihan_d">D</option>
                        <option value="pilihan_e">E</option>
                    </select>
                    <div class="text-danger">
                        @error('jawaban') {{$message}} @enderror
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
                <div class="form-group mb-3">
                    <label for="pilihan_a">Pilihan A</label>
                    <input type="text" class="form-control" wire:model="pilihan_a">
                    <div class="text-danger">
                        @error('pilihan_a') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="pilihan_b">Pilihan B</label>
                    <input type="text" class="form-control" wire:model="pilihan_b">
                    <div class="text-danger">
                        @error('pilihan_b') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="pilihan_c">Pilihan C</label>
                    <input type="text" class="form-control" wire:model="pilihan_c">
                    <div class="text-danger">
                        @error('pilihan_c') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="pilihan_d">Pilihan D</label>
                    <input type="text" class="form-control" wire:model="pilihan_d">
                    <div class="text-danger">
                        @error('pilihan_d') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="pilihan_e">Pilihan E</label>
                    <input type="text" class="form-control" wire:model="pilihan_e">
                    <div class="text-danger">
                        @error('pilihan_e') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="jawaban">Kunci Jawaban</label>
                    <select wire:model="jawaban" class="form-control">
                        <option value="">Pilih Kunci Jawaban</option>
                        <option value="pilihan_a">A</option>
                        <option value="pilihan_b">B</option>
                        <option value="pilihan_c">C</option>
                        <option value="pilihan_d">D</option>
                        <option value="pilihan_e">E</option>
                    </select>
                    <div class="text-danger">
                        @error('jawaban') {{$message}} @enderror
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
        window.addEventListener('closeModal', event => {
            $('#c_sumatif').modal('hide');
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

