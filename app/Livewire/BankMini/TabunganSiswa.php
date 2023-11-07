<?php

namespace App\Livewire\BankMini;

use Livewire\Component;
use App\Models\TabunganSiswa as TabelTabungan;
use App\Models\LogTabungan;
use App\Models\DataSiswa as TabelSiswa;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class TabunganSiswa extends Component
{
    public $id_tabungan , $id_siswa, $id_user, $id_data, $nama_lengkap, $nominal, $jenis , $id_log_tabungan, $jumlah_saldo ;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $tabungan_siswa = TabelTabungan::all();
        $data  = TabelSiswa::leftJoin('tabungan_siswa','tabungan_siswa.id_siswa','data_siswa.id_siswa')-> where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.bank-mini.tabungan-siswa', compact('data'));
    }
  public function insert(){
        $this->validate([
            'id_siswa' => 'required',
            'id_log_tabungan' => 'required',
        ]);

        $data2 = TabelSiswa::create([
            'jenkel'=> $this->jenkel,
            'no_hp'=> $this->no_hp, 
            'alamat'=> $this->alamat,
        ]);

        $data = TabelTabungan::create([
            'id_siswa' => $this->id_siswa,
        ]);
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }


    public function clearForm(){
        $this->nominal = '';
    }


    public function debit($id){
       $data1 = TabelSiswa::where('data_siswa.id_siswa', $id)
       ->leftJoin('tabungan_siswa','tabungan_siswa.id_siswa','=','data_siswa.id_siswa')
       ->first();
            $this->id_siswa = $data1->id_siswa;
            $this->nama_lengkap = $data1->nama_lengkap;
            $this->id_tabungan = $data1->id_tabungan;
    }
    
    public function debitmasuk(){
        $this->validate([
           'nominal'=> 'required',
        ]);
        
        $data3 = LogTabungan::create([
            'id_tabungan'=> $this->id_tabungan,
            "nominal" => $this->nominal,
            'jenis' => "db",
            'no_invoice'=> 'DB'.date("dmyhis"),
            "log"=> "contoh log"

        ]);

        TabelTabungan::where('id_siswa', $this->id_siswa)->update([
          "jumlah_saldo" => DB::raw("jumlah_saldo + $data3->nominal")
      ]);

        
        session()->flash('sukses','Data debit berhasil masuk');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function kredit($id){
      $data1 = TabelSiswa::where('data_siswa.id_siswa', $id)
      ->leftJoin('tabungan_siswa','tabungan_siswa.id_siswa','=','data_siswa.id_siswa')
      ->first();
           $this->id_siswa = $data1->id_siswa;
           $this->nama_lengkap = $data1->nama_lengkap;
           $this->id_tabungan = $data1->id_tabungan;
     }
    public function kreditkeluar(){
        $this->validate([
           'nominal'=> 'required',
        ]);

        $data3 = LogTabungan::create([
            'id_tabungan'=> $this->id_tabungan,
            "nominal" => $this->nominal,
            'jenis' => "kd",
            'no_invoice'=> 'DB'.date("dmyhis"),
            "log"=> "contoh log"

        ]);

        $tabeltabunga = TabelTabungan::where('id_siswa', $this->id_siswa)->first();


        if((int)$this->nominal > (int)$tabeltabunga->jumlah_saldo){
          session()->flash('gagal','Data Tabungan Tidak sesuai');
      $this->clearForm();
      $this->dispatch('closeModal');
      } else {
         
        TabelTabungan::where('id_siswa', $this->id_siswa)->update([
          "jumlah_saldo" => DB::raw("jumlah_saldo - $data3->nominal")
      ]);

          session()->flash('sukses','Data kredit Berhasil di ambil');
          $this->clearForm();
          $this->dispatch('closeModal');
      }
    }
    
}