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
                          @if (Auth::user()->id_role == 6)
                          <th>Nama Siswa</th>
                          <th>Kelas</th>
                          @else
                          <th>Nama Guru</th>
                          @endif


                          <th>Tugas</th>
                          <th>Nilai</th>
                          @if (Auth::user()->id_role == 6)
                          <th>Aksi</th>
                          @endif
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d)
                  <tr>
                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                    <td>{{$d->nama_lengkap}}</td>
                    @if (Auth::user()->id_role == 6)
                    <td>{{$d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas}}</td>
                    @endif
                    <td>{{$d->nama_tugas}}</td>
                    <td>{{$d->nilai ?? 'Belum dinilai'}}</td>
                    @if (Auth::user()->id_role == 6)
                    <td>
                        <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#review" wire:click='review("{{$d->id_submit}}")'>Review Tugas</a>
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

    <div class="modal fade" id="review" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Review Tugas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    Nama Tugas : {{ $this->nama_tugas }}
                </div>
                <div class="mb-3">
                    Deskripsi :
                    <p>{!! $this->deskripsi !!}</p>
                </div>
                <div class="mb-3">
                    Jawaban :
                    <p>{!! $this->jawaban !!}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="">Nilai</label>
                    <input type="number" wire:model.live="nilai" class="form-control">
                    <div class="text-danger">
                        @error('nilai')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='submitReview()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <script>
        window.addEventListener('closeModal', event => {
            $('#review').modal('hide');
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

