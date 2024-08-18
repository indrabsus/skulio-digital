<?php

namespace App\Livewire\Keuangan;

use App\Models\LogSpp as ModelsLogSpp;
use Auth;
use Livewire\Component;
use App\Models\LogTabungan as TabelLog;
use App\Models\LogTabungan as ModelsLogTabungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;
use Str;

class LogSpp extends Component
{
    public  $nominal, $jenis , $no_invoice, $log, $id_logspp;
    use WithPagination;
    public $bln ='';
    public $thn='';
    public $cari = '';
    public $result = 10;
    public function render()
    {$kls = Str::after(Auth::user()->username, 'stafkeuangan');
        if(Auth::user()->id_role == 14){
            $data  = ModelsLogSpp::leftJoin('data_siswa','data_siswa.id_siswa','log_spp.id_siswa')
            ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->select('log_spp.*','data_siswa.nama_lengkap','jurusan.singkatan','kelas.tingkat','kelas.nama_kelas')
            ->orderBy('log_spp.created_at','desc')
            ->where('kelas.tingkat', $kls)
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
        } else {
            $data  = ModelsLogSpp::leftJoin('data_siswa','data_siswa.id_siswa','log_spp.id_siswa')
            ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->select('log_spp.*','data_siswa.nama_lengkap','jurusan.singkatan','kelas.tingkat','kelas.nama_kelas')
            ->orderBy('log_spp.created_at','desc')
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
        }

            return view('livewire.keuangan.log-spp', compact('data'));
    }

    public function k_delete($id){
        $this->id_logspp = $id;
    }
    public function delete(){
        ModelsLogSpp::where('id_logspp', $this->id_logspp)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->dispatch('closeModal');
    }

}
