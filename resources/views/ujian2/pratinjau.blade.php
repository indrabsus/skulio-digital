@extends('ujian2.layouts.app')

@section('konten')
<style>
    /* Menghilangkan bullet point dari daftar */
    ul.no-bullets {
        list-style-type: none; /* Menghilangkan bullet point */
        padding: 0; /* Menghapus padding default */
        margin: 0; /* Menghapus margin default */
    }

    /* Mengatur jarak antara elemen daftar jika diperlukan */
    ul.no-bullets li {
        margin-bottom: 5px; /* Atur jarak sesuai kebutuhan */
    }

    body {

}

</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
   <div class="container">
   <span class="navbar-brand" id="timer">{{ $test->nama_lengkap }} - {{ $test->nama_sumatif }}</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    {{-- <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{route('done2')}}">Keluar <i class="fa fa-sign-out" aria-hidden="true"></i></a>
        </li>
      </ul>
    </div> --}}
   </div>
  </nav>

  <div class="container mt-3">
        @csrf
        @php
        // Ambil data soal dan jawaban siswa
        $soal = App\Models\Sumatif::leftJoin('tampung_soal', 'tampung_soal.id_soalujian', 'sumatif.id_soalujian')
            ->leftJoin('soal', 'soal.id_soal', 'tampung_soal.id_soal')
            ->where('sumatif.id_sumatif', $test->id_sumatif)
            ->get();

        $jawaban = App\Models\NilaiUjian::where('id_nilaiujian', $test->id_nilaiujian)->first();

        // Parsing jawaban siswa jika ada, dengan menghilangkan spasi
        $parsedJawaban = [];
        if ($jawaban && $jawaban->jawaban_siswa) {
            $answers = explode(',', $jawaban->jawaban_siswa);
            foreach ($answers as $answer) {
                list($id_soal, $response) = explode(':', $answer);
                $parsedJawaban[trim($id_soal)] = $response; // Gunakan trim() di sini
            }
        }
        @endphp

        @foreach ($soal as $d)
            @if ($d->gambar)
                <img src="{{ asset('storage/'.$d->gambar) }}" alt="" width="300px" class="mb-3 mt-3">
            @endif
            <p><strong>{{ $loop->iteration }}</strong>. {!! $d->soal !!}</p>

            <ul class="no-bullets" id="options-{{ $d->id_soal }}">
                @foreach (['a', 'b', 'c', 'd', 'e'] as $option)
                    <li>
                        <input type="radio" name="pilihan_{{ $d->id_soal }}" value="pilihan_{{ $option }}"
                               {{ isset($parsedJawaban[$d->id_soal]) && $parsedJawaban[$d->id_soal] === 'pilihan_' . $option ? 'checked' : '' }} disabled>
                        {{ $d->{'pilihan_' . $option} }}
                        @if ('pilihan_' . $option === $d->jawaban)
                            <span class="text-success"><strong>(Kunci Jawaban)</strong></span>
                        @endif
                    </li>
                @endforeach
            </ul>
            <hr>
        @endforeach
</div>








<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('ul.no-bullets').forEach(function(ul) {
        let items = Array.from(ul.querySelectorAll('li'));
        items.sort(() => Math.random() - 0.5); // Acak urutan
        ul.innerHTML = ''; // Kosongkan daftar
        items.forEach(item => ul.appendChild(item)); // Tambahkan item yang sudah diacak
    });
});
</script>



{{-- <iframe src="{{$test->link}}" frameborder="0" target="_self"></iframe> --}}
@php
    $us = App\Models\DataSiswa::where('id_user', Auth::user()->id)->first();
@endphp


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


@endsection
