<div>
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
          <div class="row flex-grow-1">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Jumlah Nasabah Aktif</h6>
                  </div>
                  <div>
                    <h3 class="mb-2">{{ $count }} Orang</h3>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Total Saldo</h6>
                  </div>
                  <div>
                    <h3 class="mb-2">Rp.{{number_format( $total ,0,',','.')}}</h3>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Total Debit</h6>
                  </div>
                  <div>
                    <h3 class="mb-2">Rp.{{number_format( $sumdebit ,0,',','.')}}</h3>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Total Kredit</h6>
                  </div>
                  <div><h3 class="mb-2">Rp.{{number_format( $sumkredit ,0,',','.')}}</h3></div>
                </div>
              </div>
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


