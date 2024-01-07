<?php

namespace App\Livewire\Ppdb;

use Livewire\Component;
use App\Models\LogPpdb as TabelLogPpdb;
use App\Models\MasterPpdb;
use App\Models\SiswaPpdb;
use Livewire\WithPagination;

class LogPpdb extends Component
{
    public $id_log, $id_siswa, $nominal , $jenis, $date;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $siswa_ppdb = SiswaPpdb::all();
        $data  = TabelLogPpdb ::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','log_ppdb.id_siswa')->orderBy('id_log','desc')->where('nama_lengkap', 'like','%'.$this->cari.'%')
        ->select('nama_lengkap','nominal','jenis','log_ppdb.created_at','id_log')
        ->paginate($this->result);
        return view('livewire.ppdb.log-ppdb', compact('data','siswa_ppdb'));
    }

    public function clearForm(){
        $this->nominal = '';
        $this->id_siswa = '';
        $this->jenis = '';
    }
    public function edit($id){
        $data = TabelLogPpdb::where('id_log', $id)->first();
        $this->nominal = $data -> nominal;
        $this->jenis  =  $data -> jenis;
        $this->id_log =  $data -> id_log;
        $this->no_invoice =  $data -> no_invoice;
    }
    public function update(){
        $this->validate([
            'nominal' => 'required',
            'jenis' => 'required',
        ]);
        $data = TabelLogPpdb::where('id_log', $this->id_log)->update([
            'nominal' => $this->nominal,
            'jenis' => $this->jenis,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $data = TabelLogPpdb::where('id_log', $id)->first();
        $this->id_log= $id;
        $this->jenis = $data->jenis;
        $this->id_siswa = $data->id_siswa;
    }
    public function delete(){
        if($this->jenis == 'd'){
            SiswaPpdb::where('id_siswa', $this->id_siswa)->update([
                'bayar_daftar' => 'n'
            ]);
            TabelLogPpdb::where('id_log',$this->id_log)->delete();
            session()->flash('sukses','Data berhasil dihapus');
            $this->clearForm();
            $this->dispatch('closeModal');
        } else {
            TabelLogPpdb::where('id_log',$this->id_log)->delete();
            session()->flash('sukses','Data berhasil dihapus');
            $this->clearForm();
            $this->dispatch('closeModal');
        }

    }
}


