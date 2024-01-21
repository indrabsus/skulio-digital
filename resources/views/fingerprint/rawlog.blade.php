@extends('fingerprint.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h3>Log Absen Guru</h3>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                        <div id="rawlogsc"></div>
                  </li>

                </ul>
              </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        setInterval(function(){
            $("#rawlogsc").load("{{route('rawlogsc')}}")
        },1000)
    })
</script>

@endsection
