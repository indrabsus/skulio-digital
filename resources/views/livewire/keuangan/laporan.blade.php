<div>
     <h3>Laporan Keuangan Sekolah</h3>
     <div class="row mt-3">
         <div class="col-lg-6">
             <table class="table table-bordered">
                 <tr>
                     <td>Kas Awal</td><td>Rp. {{ number_format($set->kas_awal,0,',','.') }}</td>
                 </tr>
                 <tr>
                     <td>Pendapatan SPP</td><td>Rp. {{ number_format($spp,0,',','.') }}</td>
                 </tr>
                 <tr>
                     <td>Pendapatan Luar SPP</td><td>Rp. {{ number_format($masukluarspp,0,',','.') }}</td>
                 </tr>
                 <tr>
                     <td>Pengeluaran</td><td>Rp. {{ number_format($pengeluaran,0,',','.') }}</td>
                 </tr>
                 <tr>
                     <td>Total</td><td>Rp. {{ number_format($set->kas_awal + $spp + $masukluarspp - $pengeluaran,0,',','.') }}</td>
                 </tr>
             </table>
         </div>

     </div>
 </div>
