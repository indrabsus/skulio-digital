<div>
    <div class="row">

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
        <div class="col">
                <div class="row justify-content-between mt-2">
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#tarik" wire:click='tarik()'>
                            Tarik Data
                          </button>
                    </div>

                    <div class="col-lg-3">
                        <div class="input-group input-group-sm mb-3">
                          <div class="col-3">
                            <select class="form-control" wire:model.live="result">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                            <input type="text" class="form-control" placeholder="Cari..." aria-label="Username" aria-describedby="basic-addon1" wire:model.live="cari">
                            <span class="input-group-text" id="basic-addon1">Cari</span>
                          </div>
                    </div>
                </div>
               <div class="table-responsive">
                <table class="table table-stripped">
                  <thead>
                      <tr>
                          <th>UID</th>
                          <th>Nama</th>
                          <th>Role</th>
                          <th>Waktu</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $d => $z)
                  @php
                      $x = App\Models\DataUser::leftJoin('users','users.id','data_user.id_user')
                      ->leftJoin('roles','roles.id_role','users.id_role')
                      ->where('uid_fp', $z['uid'])->first();
                  @endphp
                      <tr>
                          <td>{{$z['uid']}}</td>
                          <td>{{$x->nama_lengkap ?? ''}}</td>
                          <td>{{$x->nama_role ?? ''}}</td>
                          <td>{{$z['timestamp']}}</td>

                      </tr>
                  @endforeach
                  </tbody>
              </table>
               </div>
        </div>
    </div>

{{-- Delete Modal --}}
<div class="modal fade" id="tarik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tarik Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Apakah anda yakin untuk menarik data?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" wire:click='tarik()'>Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    window.addEventListener('closeModal', event => {
        $('#tarik').modal('hide');
    })
    window.addEventListener('closeModal', event => {
        $('#izin').modal('hide');
    })
    window.addEventListener('closeModal', event => {
        $('#k_hapus').modal('hide');
    })
    window.addEventListener('closeModal', event => {
        $('#k_reset').modal('hide');
    })
  </script>
</div>

