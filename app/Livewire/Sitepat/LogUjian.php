<?php

namespace App\Livewire\Sitepat;

use Auth;
use Livewire\Component;
use App\Models\LogTabungan as TabelLog;
use App\Models\LogTabungan as ModelsLogTabungan;
use Livewire\WithPagination;

class LogUjian extends Component
{
    public  $nominal, $jenis , $no_invoice, $log, $id_log  ;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = \App\Models\LogUjian::leftJoin('data_siswa','data_siswa.id_siswa','log_ujian.id_siswa')
        ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->orderBy('id_log','desc')
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
            return view('livewire.sitepat.log-ujian', compact('data'));

    }
    
    public function c_delete($id){
        $this->id_log = $id;
    }
    public function delete(){
        \App\Models\LogUjian::where('id_log', $this->id_log)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->dispatch('closeModal');
    }

}
