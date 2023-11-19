<?php

namespace App\Livewire\BankMini;

use Auth;
use Livewire\Component;
use App\Models\LogTabungan as TabelLog;
use App\Models\LogTabungan as ModelsLogTabungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;

class LogTabungan extends Component
{
    public  $nominal, $jenis , $no_invoice, $log, $id_log;
    use WithPagination;
    public $bln ='';
    public $thn='';
    public $cari = '';
    public $result = 10;
    public function render()
    {
        if(Auth::user()->id_role == '8') {
            $data  = TabelLog::leftJoin('data_siswa','data_siswa.id_siswa','log_tabungan.id_siswa')
            ->orderBy('id_log_tabungan','desc')
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')
            ->where('id_user', Auth::user()->id)
            ->paginate($this->result);
            return view('livewire.bank-mini.log-tabungan', compact('data'));
        } else {
            $data  = TabelLog::leftJoin('data_siswa','data_siswa.id_siswa','log_tabungan.id_siswa')
            ->orderBy('id_log_tabungan','desc')
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
            return view('livewire.bank-mini.log-tabungan', compact('data'));
        }

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
    public function k_delete($id){
        $this->id_log = $id;
    }
    public function delete(){
        ModelsLogTabungan::where('id_log_tabungan', $this->id_log)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->dispatch('closeModal');
    }

}
