<div>
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
    <h3>Bayar SPP</h3>
    <hr>
<a href="{{ route('resettemp') }}" class="btn btn-danger btn-sm mb-3">Reset</a>
<form action="{{ route('sppproses') }}" method="post">
                <div class="row">
                <div class="col-lg-6 mb-3">
                <div id="cekkartu"></div>

                <div class="form-group mb-3">
                    <label for="">Kelas</label>
                    @php
                        $kls = App\Models\MasterSpp::all();
                        // dd($kls);
                    @endphp
                    <select name="kelas" class="form-control">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kls ?? [] as $k)
                            <option value="{{ $k->kelas ?? '' }}" {{ $data->tingkat ?? '' == $k->kelas ?? '' ? 'selected' : '' }}>{{ $k->kelas }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('kelas')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Nominal</label>
                    <input type="number" name="nominal" class="form-control" value="{{$nom->nominal ?? ''}}">
                    <div class="text-danger">
                        @error('nominal')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Bayar Via : </label>
                    <input type="radio" name="bayar" value="trf"> Transfer
                    <input type="radio" name="bayar" value="csh"> Cash
                    <div class="text-danger">
                        @error('bayar')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  @php
                      $bln = \DB::table('master_bulan')->get();
                  @endphp
                <div class="form-group mb-3">
                    <label for="">Bulan</label>
                    <select name='bulan' class="form-control">
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
                    <label for="">Status : </label>
                    <input type="radio" name="status" value="cicil"> Cicil
                    <input type="radio" name="status" value="lunas"> Lunas
                    <div class="text-danger">
                        @error('status')
                            {{$message}}
                        @enderror
                    </div>
                  </div>


                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary btn-block" type="submit">Bayar</button>
                    </div>
                </div>
                    </div>
                </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    setInterval(function() {
        fetch("{{route('sppcek')}}")
            .then(response => response.text())
            .then(html => {
                document.getElementById("cekkartu").innerHTML = html;
            })
            .catch(error => console.error('Error loading content:', error));
    }, 1000);
});

</script>
</div>
