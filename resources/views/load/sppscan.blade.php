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
<div class="form-group mb-3">
    <label for="">Kelas</label>
    <input type="text" name="kelas" value="{{$kelas}}" class="form-control" readonly>
    <div class="text-danger">
                    @error('kelas')
                        {{$message}}
                    @enderror
                </div>
</div>
<table class="table table-bordered">
    <tr>
        <th>Kelas/Bulan</th>
        <th>Nominal</th>
        <th>Status</th>
    </tr>
    @php
        $lst = App\Models\LogSpp::where('id_siswa', $id_siswa)->orderBy('created_at', 'desc')->limit(3)->get();
    @endphp
    @foreach ($lst as $l)
    <tr>
        <td>{{ $l->keterangan }}</td>
        <td>{{ 'Rp.'.number_format($l->nominal,0,',','.') }}</td>

        <td>{{ $l->status }}</td>
    </tr>
    @endforeach
</table>

