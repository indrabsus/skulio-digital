<div class="form-group mb-3">
    <label for="">No Kartu</label>
    <input type="text" name="no_rfid" value="{{$scan}}" class="form-control" placeholder="Tempelkan Kartu!" readonly>
    <div class="text-danger">
                    @error('no_rfid')
                        {{$message}}
                    @enderror
                </div>
</div>
<input type="text" name="id_siswa" value="{{$id_siswa}}" class="form-control" hidden>
<div class="form-group mb-3">
    <label for="">Nama</label>
    <input type="text" name="nama_lengkap" value="{{$nama}}" class="form-control" readonly>
    <div class="text-danger">
                    @error('nama_lengkap')
                        {{$message}}
                    @enderror
                </div>
</div>
