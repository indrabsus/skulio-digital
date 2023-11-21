<?php

namespace App\Livewire\Sitepat;

use App\Models\LogCheat;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LogKecurangan extends Component
{
    public  $nominal, $jenis , $no_invoice, $log, $id_logc  ;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = LogCheat::leftJoin('data_siswa','data_siswa.id_siswa','log_cheats.id_siswa')
        ->leftJoin('ujian','ujian.id_ujian','log_cheats.id_ujian')
        ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->orderBy('id_logc','desc')
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
            return view('livewire.sitepat.log-kecurangan', compact('data'));

    }
    
    public function c_delete($id){
        $this->id_logc = $id;
    }
    public function delete(){
        LogCheat::where('id_logc', $this->id_logc)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->dispatch('closeModal');
    }

}
