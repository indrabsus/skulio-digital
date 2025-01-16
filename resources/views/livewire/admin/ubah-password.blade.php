<div class="row">
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
    <div class="col-lg-3">
   <form action="{{route('updatepassword')}}" method="post">
   <div class="form-group mb-3">
    <label for="">Password Saat Ini</label>
    <input type="password" name="old_pass" class="form-control">
    <div class="text-danger">
        @error('old_pass')
            {{$message}}
        @enderror
    </div>
  </div>
   <div class="form-group mb-3">
    <label for="">Password Baru</label>
    <input type="password" name="password" class="form-control">
    <div class="text-danger">
        @error('password')
            {{$message}}
        @enderror
    </div>
  </div>
   <div class="form-group mb-3">
    <label for="">Konfirmasi Password</label>
    <input type="password" name="k_pass" class="form-control">
    <div class="text-danger">
        @error('k_pass')
            {{$message}}
        @enderror
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
   </form>
    </div>
   </div>
