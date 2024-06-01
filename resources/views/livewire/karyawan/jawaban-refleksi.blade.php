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
                            @if (Auth::user()->id_role == 1 || Auth::user()->id_role == 4)
                            <select wire:model.live="user" class="form-control">
                                <option value="">Pilih Guru</option>
                                @foreach ($guru as $g)
                                    <option value="{{ $g->id_user }}">{{ $g->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @endif
                            <span class="input-group-text" id="basic-addon1">Pertemuan ke</span>
                            <select class="form-control" wire:model.live="pertemuan">
                                @foreach ($pert as $p)
                                <option value="{{ $p->pertemuan }}">{{ $p->pertemuan }}</option>

                                @endforeach
                            </select>

                          </div>
                    </div>
                </div>

               <?php $no=1; ?>
                @foreach ($data as $d)
                    <div class="card">
                      <div class="card-body">
                        <h3>{{ $no++ }}. {{ $d->pertanyaan }}</h3>
                    <hr>
                    @php
                    if(Auth::user()->id_role == 1 || Auth::user()->id_role == 4){
                        $ok = App\Models\JwbnRefleksi::where('id_refleksi',$d->id_refleksi)->where('id_user',$user)->first();
                    } else {
                        $ok = App\Models\JwbnRefleksi::where('id_refleksi',$d->id_refleksi)->where('id_user',Auth::user()->id)->first();
                    }

                            @endphp
                            {{ $ok == NULL ? '-': $ok->jawaban }}
                            <hr>
                            @if (Auth::user()->id_role == 6)
                            @if ($ok == NULL)
                            <a href="" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#cjawab" wire:click='cjawab("{{$d->id_refleksi}}")'>Jawab</a>
                            @else
                            <button class="btn btn-success btn-sm" disabled>Sudah dijawab</button>
                           @endif 
                            @endif
                      </div>
                    </div>
                @endforeach
        </div>
    </div>





    {{-- Edit Modal --}}
    <div class="modal fade" id="cjawab" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Jawab</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">{{ $pertanyaan }}</p>
                <div class="form-group mb-3">
                    <label for="">Jawaban</label>
                    <textarea wire:model="jawaban" cols="30" rows="10" class="form-control"></textarea>
                    <div class="text-danger">
                        @error('jawaban')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='jawab()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <script>
        window.addEventListener('closeModal', event => {
            $('#cjawab').modal('hide');
        })
      </script>

</div>

