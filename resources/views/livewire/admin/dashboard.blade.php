<div>
    <div class="row">
        <div class="col-6">
            <table class="table table-striped">
                <tr>
                    <th>No</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
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
            </table>
        </div>
    </div>
</div>
