<div>
    <div class="row">

        <div class="container">
            @if(session('sukses'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h5>Sukses!</h5>
                    {{ session('sukses') }}
                </div>
            @endif
            @if(session('gagal'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h5>Gagal!</h5>
                    {{ session('gagal') }}
                </div>
            @endif
        </div>
        <div class="col">
            <div class="row justify-content-between mt-2">
                <div class="col-lg-3">
                    <form action="{{ route('rekapharianspp') }}" method="get" target="_blank">
                        <div class="input-group input-group-sm mb-3">
                            <div class="col-3">
                                <input type="date" class="form-control" name="date">
                          </div>
                             <button class="input-group-text" id="basic-addon1">Print</button>
                            </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-3">
                        <div class="col-3">
                                <form action="{{route('printsppbulanan')}}" method="get" target="_blank">
                                <select class="form-control" name="bln">
                                    <option value="">Pilih Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-control" name="thn">
                                    <option value="">Pilih Tahun</option>
                                    <option value="{{date('Y') - 1}}">{{date('Y') - 1}}</option>
                                    <option value="{{date('Y') }}">{{date('Y') }}</option>
                                    <option value="{{date('Y') + 1}}">{{date('Y') + 1}}</option>
                                </select>
                            </div>
                            <button class="input-group-text" type="submit">Print</button>
                        </form>
                        </div>
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
                        <input type="text" class="form-control" placeholder="Cari..." aria-label="Username"
                            aria-describedby="basic-addon1" wire:model.live="cari">
                        <span class="input-group-text" id="basic-addon1">Cari</span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>Print</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            @if (Auth::user()->id_role != 14)
                            <th>Hapus</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                            <tr>
                                <td><a href="{{ route('printsppsiswa', $d->id_logspp) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa-solid fa-print"></i></a>
                                </td>
                                <td>{{ $d->nama_lengkap }}</td>
                                <td>{{ $d->tingkat.' '.$d->singkatan.' '.$d->nama_kelas }}</td>
                                <td>Rp.{{ number_format($d->nominal,0,',','.') }} ({{ strtoupper($d->bayar) }})</td>
                                <td>Kelas {{$d->keterangan}}</td>
                                <td>{{ strtoupper($d->status) }}</td>
                                <td>{{ date('d F Y H:i', strtotime($d->created_at)) }}</td>
                                @if (Auth::user()->id_role != 14)
                                <td><a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#k_hapus" wire:click="k_delete('{{$d->id_logspp}}')"><i class="fa-solid fa-trash"></i></a></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $data->links() }}
        </div>
    </div>
    <div class="modal fade" id="k_hapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin menghapus data ini?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click='delete()'>Save changes</button>
            </div>
          </div>
        </div>
      </div>
    <script>
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#debit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('kredit').modal('hide');
        })

    </script>

</div>
