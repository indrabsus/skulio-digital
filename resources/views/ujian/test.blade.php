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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function onFocus(){ console.log('browser window activated'); }
function onBlur(){

  window.location = '{{route('cit')}}'
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

          window.location = '{{route('cit')}}';
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
<!-- <script>
  var timeout;
document.onmousemove = function(){
  clearTimeout(timeout);
  timeout = setTimeout(function(){alert("Kamu ga aktif selama 6 detik (dianggap kecurangan)");}, 6000);
}
</script> -->
<script>
  $('iframe').contents().mousemove( function(e) {
    console.log( e.clientX, e.clientY );
});
</script>

@endsection
