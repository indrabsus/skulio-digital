<?php

namespace App\Livewire\BankMini;

use Livewire\Component;
use App\Models\LogTabungan as TabelLog;
use Livewire\WithPagination;

class LogTabungan extends Component
{
    public  $nominal, $jenis , $no_invoice, $log  ;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelLog::leftJoin('tabungan_siswa','tabungan_siswa.id_tabungan','log_tabungan.id_tabungan')
        ->leftJoin('data_siswa','data_siswa.id_siswa','tabungan_siswa.id_siswa')
        ->orderBy('id_log_tabungan','desc')
        ->where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.bank-mini.log-tabungan', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nominal' => 'required',
            'jenis' => 'required',
            'no_invoice' => 'required',
            'log' => 'required'
        ]);
        $data = TabelLog::create([
            
            'nominal' => $this->nominal,
            'jenis' => $this->jenis,
            'no_invoice' => $this->no_invoice,
            'log' => $this->log,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nominal = '';
        $this->jenis = '';
        $this->no_invoice = '';
        $this->log = '';
    }

}