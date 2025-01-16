<div class="row">
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
    <div class="col-lg-3">
   <form action="{{route('updateprofil')}}" method="post">
   <div class="form-group mb-3">
    <label for="">Nama Lengkap</label>
    <input type="text" name="nama_lengkap" class="form-control" value="{{ $data->nama_lengkap }}">
    <div class="text-danger">
        @error('nama_lengkap')
            {{$message}}
        @enderror
    </div>
  </div>
   <div class="form-group mb-3">
    <label for="">Kelas</label>
    <input type="text" class="form-control" value="{{ $data->tingkat.' '.$data->singkatan.' '.$data->nama_kelas }}" disabled>
    <div class="text-danger">
        @error('kelas')
            {{$message}}
        @enderror
    </div>
  </div>
   <div class="form-group mb-3">
    <label for="">No Handphone</label>
    <input type="text" name="no_hp" class="form-control" value="{{ $data->no_hp }}">
    <div class="text-danger">
        @error('no_hp')
            {{$message}}
        @enderror
    </div>
  </div>
   <div class="form-group mb-3">
    <label for="">No Induk Sekolah (NIS)</label>
    <input type="text" name="nis" class="form-control" value="{{ $data->nis }}">
    <div class="text-danger">
        @error('nis')
            {{$message}}
        @enderror
    </div>
  </div>
   <div class="form-group mb-3">
    <label for="">Jenis Kelamin</label>
    <select name="jenkel" class="form-control">
        <option value="l" @if($data->jenkel == 'l') selected @endif>Laki-laki</option>
        <option value="p" @if($data->jenkel == 'p') selected @endif>Perempuan</option>
    </select>
    <div class="text-danger">
        @error('jenkel')
            {{$message}}
        @enderror
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
   </form>
    </div>
   </div>
