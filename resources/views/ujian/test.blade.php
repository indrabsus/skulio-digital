@extends('ujian.layouts.app')

@section('konten')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
   <div class="container">
   <span class="navbar-brand" id="timer">Timer</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{route('done')}}">Keluar <i class="fa fa-sign-out" aria-hidden="true"></i></a>
        </li>
      </ul>
    </div>
   </div>
  </nav>


<iframe src="{{$test->link}}" frameborder="0" target="_self"></iframe>
@php
    $us = App\Models\DataSiswa::where('id_user', Auth::user()->id)->first();
@endphp


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function onFocus(){ console.log('browser window activated'); }
function onBlur(){

//   window.location = '{{route('cit')}}'
  $.ajax({
    url: '{{route('cit')}}', // Ganti dengan URL endpoint Anda
    type: 'GET',
    success: function(response) {
        // Tambahkan logika di sini untuk menangani respons dari server jika diperlukan
        console.log('Data berhasil disimpan ke database');
    },
    error: function(xhr, status, error) {
        // Tambahkan logika di sini untuk menangani kesalahan jika diperlukan
        console.error(error);
    }
});
// let nama = '{{ $us->nama_lengkap }}'
// let tokenTelegram = '6019753763:AAGy5F-9h3jAKgLM38AhaiIM5LZ3oyYfXFM';
// let grupId = -926083732;
// let kelas = '{{ Illuminate\Support\Facades\Session::get('nama_kelas') }}';
// let ujian = '{{ Illuminate\Support\Facades\Session::get('nama_ujian') }}';
// let text = nama+', Kelas '+kelas+' telah terdeteksi kecurangan dalam Ujian '+ujian
// $.ajax({
//                     url: 'https://api.telegram.org/bot' + tokenTelegram + '/sendMessage',
//                     method: 'GET',
//                     data: {
//                         chat_id: grupId,
//                         text: text
//                     },
//                     success: function(response) {
//                         console.log('Pesan terkirim ke Telegram');
//                     },
//                     error: function(xhr, status, error) {
//                         console.error('Error mengirim pesan ke Telegram: ' + error);
//                     }
//                 });
}


var inter;
var iframeFocused;
window.focus();      // I needed this for events to fire afterwards initially
addEventListener('focus', function(e){
console.log('global window focused');
if(iframeFocused){
    console.log('iframe lost focus');
    iframeFocused = false;
    clearInterval(inter);
}
else onFocus();
});

addEventListener('blur', function(e){
console.log('Soal Sudah ditampilkan');
if(document.hasFocus()){
    console.log('Siswa sedang mengerjakan');
    iframeFocused = true;
    inter = setInterval(()=>{
        if(!document.hasFocus()){

        //   window.location = '{{route('cit')}}';
        // jQuery AJAX request
    $.ajax({
    url: '{{route('cit')}}', // Ganti dengan URL endpoint Anda
    type: 'GET',
    success: function(response) {
        // Tambahkan logika di sini untuk menangani respons dari server jika diperlukan
        console.log('Data berhasil disimpan ke database');
    },
    error: function(xhr, status, error) {
        // Tambahkan logika di sini untuk menangani kesalahan jika diperlukan
        console.error(error);
    }
});
// let nama = '{{ $us->nama_lengkap }}'
// let tokenTelegram = '6019753763:AAGy5F-9h3jAKgLM38AhaiIM5LZ3oyYfXFM';
// let grupId = -926083732;
// let kelas = '{{ Illuminate\Support\Facades\Session::get('nama_kelas') }}';
// let ujian = '{{ Illuminate\Support\Facades\Session::get('nama_ujian') }}';
// let text = nama+', Kelas '+kelas+' telah terdeteksi kecurangan dalam Ujian '+ujian
// $.ajax({
//                     url: 'https://api.telegram.org/bot' + tokenTelegram + '/sendMessage',
//                     method: 'GET',
//                     data: {
//                         chat_id: grupId,
//                         text: text
//                     },
//                     success: function(response) {
//                         console.log('Pesan terkirim ke Telegram');
//                     },
//                     error: function(xhr, status, error) {
//                         console.error('Error mengirim pesan ke Telegram: ' + error);
//                     }
//                 });

            iframeFocused = false;
            onBlur();
            clearInterval(inter);
        }
    },100);
}
else onBlur();
});
</script>
<script>
    // Mengatur waktu akhir countdown (dalam detik)
    var examStartTime = new Date('{{ session('start') }}' * 1000);
    var examDuration = {{ $test->waktu }};
    var countDownDate = new Date(examStartTime.getTime() + examDuration * 60 * 1000);

// Memperbarui hitungan mundur setiap 1 detik
var x = setInterval(function() {

  // Mendapatkan waktu saat ini
  var now = new Date().getTime()
  // Menghitung selisih waktu antara waktu akhir dan waktu saat ini
  var distance = countDownDate - now;
  // Menghitung waktu dalam format menit dan detik
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Menampilkan waktu dalam elemen HTML yang ditentukan
  document.getElementById("timer").innerHTML = hours + ":" + minutes + ":" + seconds;

  // Jika waktu hitung mundur berakhir, tampilkan pesan
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "Waktu telah habis!";

  //   $.get( '{{route('done')}}', function() {
  // console.log('soal beres')
  // });

  // location.reload();

  }
}, 1000);

</script>


@endsection
