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
                    @if (Auth::user()->id_role == 6)
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#add">
                            Tambah
                          </button>
                    </div>
                    @endif
                    <div class="col-lg-3">
                        <div class="input-group input-group-sm mb-3">
                            <div class="form-group">
                                <select class="form-control" wire:model.live="cari_kelas">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
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
                          <th>Nama Tugas</th>
                          <th>Mapel</th>
                          <th>Kelas</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                  <tr>
                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                    <td>{{$d->nama_tugas}}</td>
                    <td>{{$d->nama_pelajaran}}</td>
                    <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                    <td>

                    @if (Auth::user()->id_role == 8)
                    @php
                            $hitung = App\Models\SubmitTugas::where('id_tugas', $d->id_tugas)
                            ->where('id_user', Auth::user()->id)
                            ->count();
                        @endphp
                    @if ($hitung > 0)
                    <button class="btn btn-success btn-xs" disabled>Sudah dikerjakan</button>
                    @else
                    <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#kerjakan" wire:click='kerjakan("{{$d->id_tugas}}")'>Kerjakan</a>
                    @endif

                    @endif
                    @if (Auth::user()->id_role == 6)
                        <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#edit" wire:click='edit("{{$d->id_tugas}}")'><i class="fa-solid fa-edit"></i></a>
                        <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="c_delete('{{$d->id_tugas}}')"><i class="fa-solid fa-trash"></i></a>
                        @endif
                    </td>
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
                    <label for="">Nama Tugas</label>
                    <input type="text" wire:model.live="nama_tugas" class="form-control">
                    <div class="text-danger">
                        @error('nama_tugas')
                            {{$message}}
                        @enderror
                    </div>
                  </div>

                  @if ($this->link_youtube != null)
                        @php
                            parse_str(parse_url($this->link_youtube, PHP_URL_QUERY), $queryParams);
                  $videoId = $queryParams['v'];
                        @endphp
                        <div>
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId ?? '' }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                          </div>
                  @endif

                <div class="form-group mb-3">
                    <label for="">Link Youtube (Jika ada)</label>
                    <input type="text" wire:model.live="link_youtube" class="form-control">
                    <div class="text-danger">
                        @error('link_youtube')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="soal">Deskripsi</label>
                    <textarea id="deskripsi" cols="30" rows="10" class="form-control" wire:model="deskripsi"></textarea>
                    <div class="text-danger">
                        @error('deskripsi') {{$message}} @enderror
                    </div>
                </div>
                  <div class="form-group mb-3">
                    <label for="soal">Kelas</label>
                    <select class="form-control" wire:model="id_mapelkelas">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{$k->id_mapelkelas}}">{{$k->tingkat.' '.$k->singkatan.' '.$k->nama_kelas}} - {{$k->nama_pelajaran}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_mapelkelas') {{$message}} @enderror
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
                    <label for="">Nama Tugas</label>
                    <input type="text" wire:model.live="nama_tugas" class="form-control">
                    <div class="text-danger">
                        @error('nama_tugas')
                            {{$message}}
                        @enderror
                    </div>
                  </div>

                  @if ($this->link_youtube != null)
                        @php
                            parse_str(parse_url($this->link_youtube, PHP_URL_QUERY), $queryParams);
                  $videoId = $queryParams['v'];
                        @endphp
                        <div>
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId ?? '' }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                          </div>
                  @endif

                <div class="form-group mb-3">
                    <label for="">Link Youtube (Jika ada)</label>
                    <input type="text" wire:model.live="link_youtube" class="form-control">
                    <div class="text-danger">
                        @error('link_youtube')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="soal">Deskripsi</label>
                    <textarea id="deskripsi2" cols="30" rows="10" class="form-control" wire:model="deskripsi"></textarea>
                    <div class="text-danger">
                        @error('deskripsi') {{$message}} @enderror
                    </div>
                </div>
                  <div class="form-group mb-3">
                    <label for="soal">Kelas</label>
                    <select class="form-control" wire:model="id_mapelkelas">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $k)
                        <option value="{{$k->id_mapelkelas}}">{{$k->tingkat.' '.$k->singkatan.' '.$k->nama_kelas}} - {{$k->nama_pelajaran}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_mapelkelas') {{$message}} @enderror
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
    <div class="modal fade" id="kerjakan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Kerjakan Tugas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    Nama Tugas : {{ $this->nama_tugas }}
                </div>
                <div class="mb-3">
                    @if ($this->link_youtube != null)
                        @php
                            parse_str(parse_url($this->link_youtube, PHP_URL_QUERY), $queryParams);
                  $videoId = $queryParams['v'];
                        @endphp
                        <div>
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId ?? '' }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                          </div>
                  @endif
                </div>
                <div class="mb-3">
                    Deskripsi :
                    <p>{!! $this->deskripsi !!}</p>
                </div>
                <div class="mb-3">
                    <textarea id="jawaban" cols="30" rows="10" class="form-control" wire:model="jawaban"></textarea>
                </div>
                <div class="form-group mb-3">
                    <input type="checkbox" wire:model="selesai"> Saya yakin ini jawaban saya sendiri dan tidak melakukan kecurangan apapun
                    <div class="text-danger">
                        @error('selesai') {{$message}} @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='submitTugas()'>Kumpulkan</button>
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
            $('#kerjakan').modal('hide');
        })
      </script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('deskripsi');

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

        document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('deskripsi2');

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
        document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('jawaban');

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

