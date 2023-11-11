<?php

namespace App\Livewire\BankMini;

use Livewire\Component;
use App\Models\TabunganSiswa as TabelTabungan;
use App\Models\LogTabungan;
use App\Models\DataSiswa as TabelSiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class TabunganSiswa extends Component
{
    public $id_tabungan , $id_kelas, $singkatan, $id_jurusan, $tingkat, $id_siswa, $nama_kelas, $id_user, $id_data, $nama_lengkap, $nominal, $jenis , $id_log_tabungan, $jumlah_saldo ;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $tabungan_siswa = TabelTabungan::all();
        $data  = TabelSiswa::leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')->leftJoin('tabungan_siswa','tabungan_siswa.id_siswa','data_siswa.id_siswa')
        ->orderBy('id_tabungan','desc')
        -> where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.bank-mini.tabungan-siswa', compact('data'));
    }

    public function clearForm(){
        $this->nominal = '';
    }


    public function kd($id){
       $data1 = TabelSiswa::where('data_siswa.id_siswa', $id)->leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
       ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
       ->leftJoin('tabungan_siswa','tabungan_siswa.id_siswa','=','data_siswa.id_siswa')
       ->first();
       $this->id_siswa = $data1->id_siswa;
       $this->nama_lengkap = $data1->nama_lengkap;
       $this->id_tabungan = $data1->id_tabungan;
       $this->id_jurusan = $data1->id_jurusan;
       $this->nama_kelas = $data1->nama_kelas;
       $this->tingkat = $data1->tingkat;
       $this->singkatan = $data1->singkatan;
    }
    
    public function kdMasuk(){
        $this->validate([
           'nominal'=> 'required',
        ]);
        $invoice = 'KD'.date("dmyh").$this->id_siswa;
        $countKd = LogTabungan::where('no_invoice', $invoice)
        ->where('nominal', $this->nominal)
        ->count();
        
        if($countKd > 0 ){
            session()->flash('gagal','Siswa sudah menabung, silakan coba 1 jam lagi');
            $this->clearForm();
            $this->dispatch('closeModal');
        
        } else {
            $data3 = LogTabungan::create([
                'id_tabungan'=> $this->id_tabungan,
                "nominal" => $this->nominal,
                'jenis' => "kd",
                'no_invoice'=> $invoice,
                "log"=> " $this->nama_lengkap , $this->tingkat $this->singkatan $this->nama_kelas Sudah menabung sebesar Rp.".number_format($this->nominal),
            ]);
    
            TabelTabungan::where('id_siswa', $this->id_siswa)->update([
              "jumlah_saldo" => DB::raw("jumlah_saldo + $data3->nominal")
          ]);
    
            
            session()->flash('sukses','Data Kredit berhasil masuk');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
        
    }

    public function db($id){
      $data1 = TabelSiswa::where('data_siswa.id_siswa', $id)->leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
      ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
      ->leftJoin('tabungan_siswa','tabungan_siswa.id_siswa','=','data_siswa.id_siswa')
      ->first();
      $this->id_siswa = $data1->id_siswa;
      $this->nama_lengkap = $data1->nama_lengkap;
      $this->id_tabungan = $data1->id_tabungan;
      $this->id_jurusan = $data1->id_jurusan;
      $this->nama_kelas = $data1->nama_kelas;
      $this->tingkat = $data1->tingkat;
      $this->singkatan = $data1->singkatan;
     }
    public function dbKeluar(){
        $this->validate([
           'nominal'=> 'required',
        ]);

        $tabeltabunga = TabelTabungan::where('id_siswa', $this->id_siswa)->first();


        if((int)$this->nominal > (int)$tabeltabunga->jumlah_saldo){
          session()->flash('gagal','Data Tabungan Tidak sesuai');
      $this->clearForm();
      $this->dispatch('closeModal');
      } else {

        $data3 = LogTabungan::create([
            'id_tabungan'=> $this->id_tabungan,
            "nominal" => $this->nominal,
            'jenis' => "db",
            'no_invoice'=> 'KD'.date("dmyhis").$this->id_siswa,
            "log"=> " $this->nama_lengkap , $this->tingkat $this->singkatan $this->nama_kelas Sudah menerima uang sebesar Rp.".number_format($this->nominal)

        ]);
         
        TabelTabungan::where('id_siswa', $this->id_siswa)->update([
          "jumlah_saldo" => DB::raw("jumlah_saldo - $data3->nominal")
      ]);

          session()->flash('sukses','Data Debit Berhasil di proses');
          $this->clearForm();
          $this->dispatch('closeModal');
      }
    }
    
}