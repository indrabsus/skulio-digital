@if (session('id_kategori'))
<script>window.location = "{{ route('test2') }}";</script>
@endif
@extends('ujian2.layouts.app')

@section('konten')
<div class="container">
<div class="row justify-content-center mt-5">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">Masukan Token</h3>
                <h5 class="text-center">{{$data->nama_sumatif}}</h5>
                <hr>
                <form action="{{route('cektoken2')}}" method="post">
                    @csrf
                    <input type="text" name="id_sumatif" value="{{$data->id_sumatif}}" >
                    <input type="text" name="ctoken" value="{{$data->token}}" >
                    <input type="text" name="waktu" value="{{$data->waktu}}" >
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
