@extends('ppdb.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-lg">
            @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
            <div class="card">
                <div class="card-header">
                    <h3>Daftar Siswa Baru</h3>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <form action="{{ route('postppdb') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="nisn">NISN</label>
                                    <input type="text" class="form-control" name="nisn" value="{{ old('nisn') }}">
                                    <div class="text-danger">
                                        @error('nisn')
                                            {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nama">Nama Siswa</label>
                                    <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}">
                                    <div class="text-danger">
                                        @error('nama_lengkap')
                                            {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                            <div class="text-danger">
                                                @error('tempat_lahir')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="ttl">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                            <div class="text-danger">
                                                @error('ttl')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nik_siswa">NIK Siswa</label>
                                    <input type="text" class="form-control" name="nik_siswa" value="{{ old('nik_siswa') }}">
                                    <div class="text-danger">
                                        @error('nik_siswa')
                                            {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jenkel">Jenis Kelamin</label>
                                    <select name="jenkel" class="form-control">
                                        <option value="" {{ old('jenkel') == '' ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                        <option value="l" {{ old('jenkel') == 'l' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="p" {{ old('jenkel') == 'p' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <div class="text-danger">
                                        @error('jenkel')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="ortu">Nama Ayah</label>
                                            <input type="text" class="form-control" name="ayah" value="{{ old('ayah') }}">
                                            <div class="text-danger">
                                                @error('ayah')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="ibu">Nama Ibu</label>
                                            <input type="text" class="form-control" name="ibu" value="{{ old('ibu') }}">
                                            <div class="text-danger">
                                                @error('ibu')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="agama">Agama</label>
                                    <select name="agama" class="form-control">
                                        <option value="" {{ old('agama') == '' ? 'selected' : '' }}>Pilih Agama</option>
                                        <option value="islam" {{ old('agama') == 'islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="kristen" {{ old('agama') == 'kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="hindu" {{ old('agama') == 'hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="budha" {{ old('agama') == 'budha' ? 'selected' : '' }}>Budha</option>
                                    </select>
                                    <div class="text-danger">
                                        @error('agama')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">

                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Jalan</label>
                                    <input type="text" class="form-control" name="jalan" value="{{ old('jalan') }}">
                                    <div class="text-danger">
                                        @error('jalan')
                                            {{$message}}
                                        @enderror
                                    </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="">Rt/Rw</label>
                                    <input type="text" class="form-control" name="rtrw" value="{{ old('rtrw') }}">
                                    <div class="text-danger">
                                        @error('rtrw')
                                            {{$message}}
                                        @enderror
                                    </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Kelurahan/Desa</label>
                                    <input type="text" class="form-control" name="kelurahan" value="{{ old('kelurahan') }}">
                                    <div class="text-danger">
                                        @error('kelurahan')
                                            {{$message}}
                                        @enderror
                                    </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="">Kecamatan</label>
                                    <input type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan') }}">
                                    <div class="text-danger">
                                        @error('kecamatan')
                                            {{$message}}
                                        @enderror
                                    </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Kab/Kota</label>
                                    <input type="text" class="form-control" name="kota" value="{{ old('kota') }}">
                                    <div class="text-danger">
                                        @error('kota')
                                            {{$message}}
                                        @enderror
                                    </div>
                                        </div>
                                    </div>
                                     </div>
                                <div class="form-group mb-3">
                                    <label for="nohp">No Handphone (WA diutamakan)</label>
                                    <input type="text" class="form-control" name="nohp" value="{{ old('nohp') }}" placeholder="081xxx">
                                    <div class="text-danger">
                                        @error('nohp')
                                            {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="asal_sekolah">Asal Sekolah</label>
                                    <input type="text" class="form-control" name="asal_sekolah" value="{{ old('asal_sekolah') }}">
                                    <div class="text-danger">
                                        @error('asal_sekolah')
                                            {{$message}}
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="">Minat Jurusan 1</label><br>

                                            @foreach ($jurusan as $j)
                                            <input type="radio" name="minat_jurusan1" value="{{ $j->nama_jurusan }}" {{ old('minat_jurusan1') == $j->nama_jurusan ? 'checked' : '' }}>
                                            <label for="">{{ $j->nama_jurusan }}</label><br>
                                            @endforeach

                                            <div class="text-danger">
                                                @error('minat_jurusan1')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="">Minat Jurusan 2</label><br>

                                            @foreach ($jurusan as $j)
                                            <input type="radio" name="minat_jurusan2" value="{{ $j->nama_jurusan }}" {{ old('minat_jurusan2') == $j->nama_jurusan ? 'checked' : '' }}>
                                            <label for="">{{ $j->nama_jurusan }}</label><br>
                                            @endforeach

                                            <div class="text-danger">
                                                @error('minat_jurusan2')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <button class="btn btn-primary btn-sm">Kirim</button>
                    </form>
                  </li>

                </ul>
              </div>
        </div>
    </div>
</div>





@endsection
