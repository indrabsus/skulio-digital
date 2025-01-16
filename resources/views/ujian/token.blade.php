@if (session('id_ujian'))
<script>window.location = "{{ route('test') }}";</script>
@endif
@extends('ujian.layouts.app')

@section('konten')
<div class="container">
<div class="row justify-content-center mt-5">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">Masukan Token</h3>
                <h5 class="text-center">{{$data->nama_ujian}}</h5>
                <hr>
                <form action="{{route('cektoken')}}" method="post">
                    @csrf
                    <input type="text" name="id_ujian" value="{{$data->id_ujian}}" hidden>
                    <input type="text" name="ctoken" value="{{$data->token}}" hidden>
                <input type="text" class="form-control" name="token">
                <button class="btn btn-primary btn-block mt-3">Mulai Test</button>
                </form>
            </div>

        </div>
        <a href="{{route('dashboard')}}"><i class="fa fa-undo" aria-hidden="true"></i> Kembali</a>
    </div>
</div>
</div>
@endsection
