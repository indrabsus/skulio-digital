<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use App\Models\BukuOnline as TabelBukuOnline;
use App\Models\MapelKelas;
use App\Models\Materi as ModelsMateri;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Materi extends Component
{
    public $materi, $id_mapelkelas,$id_materi, $semester, $tahun_pelajaran, $tingkatan, $penilaian;
    use WithPagination;
    public $carisemester = '';
    public $caritahun = '';
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $mapelkelas = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->where('mapel_kelas.id_user',Auth::user()->id)
        ->where('aktif', 'y')
        ->get();
        $data  = ModelsMateri::orderBy('id_materi','desc')
        ->leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->where('mapel_kelas.id_user',Auth::user()->id)
        ->select('tahun','tahun_pelajaran','semester','materi.materi','materi.id_materi','kelas.nama_kelas','singkatan','tingkat','materi.created_at','nama_pelajaran','tingkatan','penilaian')
        ->where('materi', 'like','%'.$this->cari.'%')
        ->where('tahun_pelajaran', 'like','%'.$this->caritahun.'%')
        ->where('semester', 'like','%'.$this->carisemester.'%')
        ->paginate($this->result);
        return view('livewire.karyawan.materi', compact('data','mapelkelas'));
    }
    public function insert(){
        $this->validate([
            'materi' => 'required',
            'id_mapelkelas' => 'required',
            'semester' => 'required',
            'tingkatan' => 'required',
            'penilaian' => 'required',
        ]);
        $tahun = MapelKelas::where('id_mapelkelas', $this->id_mapelkelas)->first();
        $data = ModelsMateri::create([
            'materi' => $this->materi,
            'id_mapelkelas' => $this->id_mapelkelas,
            'semester' => $this->semester,
            'tahun_pelajaran' => $tahun->tahun,
            'tingkatan' => $this->tingkatan,
            'penilaian' => $this->penilaian
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->materi = '';
        $this->id_mapelkelas = '';
        $this->semester = '';
        $this->tingkatan = '';
        $this->penilaian = '';
    }
    public function edit($id){
        $data = ModelsMateri::where('id_materi', $id)->first();
        $this->materi = $data->materi;
        $this->id_mapelkelas = $data->id_mapelkelas;
        $this->semester = $data->semester;
        $this->tahun_pelajaran = $data->tahun_pelajaran;
        $this->tingkatan = $data->tingkatan;
        $this->penilaian = $data->penilaian;
        $this->id_materi = $id;
    }
    public function update(){
        $this->validate([
            'materi' => 'required',
            'id_mapelkelas' => 'required',
            'semester' => 'required',
            'tahun_pelajaran' => 'required',
            'tingkatan' => 'required',
            'penilaian' => 'required',
        ]);
        $data = ModelsMateri::where('id_materi', $this->id_materi)->update([
            'materi' => $this->materi,
            'id_mapelkelas' => $this->id_mapelkelas,
            'semester' => $this->semester,
            'tahun_pelajaran' => $this->tahun_pelajaran,
            'tingkatan' => $this->tingkatan,
            'penilaian' => $this->penilaian

        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_materi = $id;
    }
    public function delete(){
        ModelsMateri::where('id_materi',$this->id_materi)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
