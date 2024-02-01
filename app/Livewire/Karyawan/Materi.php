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
    public $materi, $id_mapelkelas,$id_materi;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $mapelkelas = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->where('mapel_kelas.id_user',Auth::user()->id)
        ->get();
        $data  = ModelsMateri::orderBy('id_materi','desc')
        ->leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->where('mapel_kelas.id_user',Auth::user()->id)
        ->where('materi', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.karyawan.materi', compact('data','mapelkelas'));
    }
    public function insert(){
        $this->validate([
            'materi' => 'required',
            'id_mapelkelas' => 'required'
        ]);
        $data = ModelsMateri::create([
            'materi' => $this->materi,
            'id_mapelkelas' => $this->id_mapelkelas,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->materi = '';
        $this->id_mapelkelas = '';
    }
    public function edit($id){
        $data = ModelsMateri::where('id_materi', $id)->first();
        $this->materi = $data->materi;
        $this->id_mapelkelas = $data->id_mapelkelas;
        $this->id_materi = $id;
    }
    public function update(){
        $this->validate([
            'materi' => 'required',
            'id_mapelkelas' => 'required'
        ]);
        $data = ModelsMateri::where('id_materi', $this->id_materi)->update([
            'materi' => $this->materi,
            'id_mapelkelas' => $this->id_mapelkelas
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
