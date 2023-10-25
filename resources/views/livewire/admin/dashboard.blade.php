<div>
    <div class="row">

        @if(session('sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
        <h5><i class="icon fas fa-check"></i> Sukses!</h5>
        {{session('sukses')}}
        </div>
        @endif
        @if(session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
        <h5><i class="icon fas fa-times"></i> Gagal!</h5>
        {{session('gagal')}}
        </div>
        @endif
        <div class="col">
            <button type="button" class="btn btn-primary btn-sm mb-3" data-coreui-toggle="modal" data-coreui-target="#add">
                Tambah
              </button>

            <table id="table-data" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                @foreach ($data as $d)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$d->nama_jurusan}}</td>
                        <td>
                            <a href="" class="btn btn-success btn-sm">Edit</a>
                            <a href="" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Jurusan</label>
                    <input type="text" wire:model.live="nama_jurusan" class="form-control">
                    <div class="text-danger">
                        @error('nama_jurusan')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='insert()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>
      <script>
        window.addEventListener('closeModal', event => {
            $('#add').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#edit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
      </script>

</div>

