<?php

namespace App\Livewire\Siswa;

use App\Models\Nilai;
use Livewire\Component;
use App\Models\BukuOnline as TabelBukuOnline;
use App\Models\MapelKelas;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Nilaiku extends Component
{
    public $matpel;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        if($this->matpel == ''){
            $data  = Nilai::leftJoin('materi','materi.id_materi','nilai.id_materi')
        ->leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','mapel_kelas.id_mapel')
        ->orderBy('id','desc')
        ->where('nilai.id_user', Auth::user()->id)
        ->where('materi', 'like','%'.$this->cari.'%')->paginate($this->result);
        } else {
            $data  = Nilai::leftJoin('materi','materi.id_materi','nilai.id_materi')
        ->leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','mapel_kelas.id_mapel')
        ->orderBy('id','desc')
        ->where('nilai.id_user', Auth::user()->id)
        ->where('mata_pelajaran.id_mapel', $this->matpel)
        ->where('materi', 'like','%'.$this->cari.'%')->paginate($this->result);
        }
        $mapel = MapelKelas::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','mapel_kelas.id_mapel')
        ->leftJoin('data_siswa','data_siswa.id_kelas','mapel_kelas.id_kelas')
        ->where('data_siswa.id_user', Auth::user()->id)
        ->get();

        return view('livewire.siswa.nilaiku', compact('data','mapel'));
    }

}
