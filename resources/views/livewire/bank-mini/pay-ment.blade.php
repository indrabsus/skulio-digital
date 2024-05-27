<div>
    <div class="container">
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
      </div>
    <h3>Top Up Saldo</h3>
    <hr>
<form action="{{ route('paymentProses') }}" method="post">
                <div class="row">
                <div class="col-lg-6 mb-3">
                <div id="cekkartu"></div>

                <div class="form-group mb-3">
                    <label for="">Top Up</label>
                    <input type="text" name="saldo" class="form-control" placeholder="Masukan Nominal">
                    <div class="text-danger">
                    @error('saldo')
                        {{$message}}
                    @enderror
                </div>
                </div>

                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary btn-block" type="submit">Top Up</button>
                    </div>
                </div>
                    </div>
                </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    setInterval(function() {
        fetch("{{route('payment')}}")
            .then(response => response.text())
            .then(html => {
                document.getElementById("cekkartu").innerHTML = html;
            })
            .catch(error => console.error('Error loading content:', error));
    }, 1000);
});

</script>
</div>