<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use App\Models\BukuOnline as TabelBukuOnline;
use App\Models\DataSiswa;
use App\Models\MapelKelas;
use App\Models\SubmitTugas;
use App\Models\Tugas as ModelsTugas;
use Cohensive\OEmbed\Facades\OEmbed;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Tugas extends Component
{
    public $id_tugas, $id_user, $id_mapelkelas, $nama_tugas, $link_youtube, $deskripsi, $jawaban;
    use WithPagination;
    public $cari_kelas ='';
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $kls = DataSiswa::where('id_user', Auth::user()->id)->first();
        $kelas = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->where('mapel_kelas.id_user', Auth::user()->id)->get();
        if(Auth::user()->id_role == 6){
            $data  = ModelsTugas::orderBy('id_tugas','desc')
            ->leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','=','tugas.id_mapelkelas')
            ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
            ->where('nama_tugas', 'like','%'.$this->cari.'%')
            ->where('tugas.id_user', Auth::user()->id)
            ->where('kelas.id_kelas', 'like','%'.$this->cari_kelas.'%')
            ->paginate($this->result);
        } else {
            $data  = ModelsTugas::orderBy('id_tugas','desc')
            ->leftJoin('kelas','kelas.id_kelas','=','tugas.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->where('nama_tugas', 'like','%'.$this->cari.'%')
            ->where('tugas.id_kelas', $kls->id_kelas)
            ->where('kelas.id_kelas', 'like','%'.$this->cari_kelas.'%')
            ->paginate($this->result);
        }
        return view('livewire.karyawan.tugas', compact('data','kelas'));
    }
    public function insert(){
        $this->validate([
            'nama_tugas' => 'required',
            'id_mapelkelas' => 'required',
            'deskripsi' => 'required',
        ]);
        $data = ModelsTugas::create([
            'nama_tugas' => $this->nama_tugas,
            'link_youtube' => $this->link_youtube,
            'id_mapelkelas' => $this->id_mapelkelas,
            'deskripsi' => $this->deskripsi,
            'id_user' => Auth::user()->id
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_tugas = '';
        $this->link_youtube = '';
        $this->id_mapelkelas = '';
        $this->deskripsi = '';
    }
    public function edit($id){
        $data = ModelsTugas::where('id_tugas', $id)->first();
        $this->nama_tugas = $data->nama_tugas;
        $this->link_youtube = $data->link_youtube;
        $this->id_tugas = $id;
        $this->id_mapelkelas = $data->id_mapelkelas;
        $this->deskripsi = $data->deskripsi;

    }
    public function kerjakan($id){
        $data = ModelsTugas::where('id_tugas', $id)->first();
        $this->nama_tugas = $data->nama_tugas;
        $this->link_youtube = $data->link_youtube;
        $this->id_tugas = $id;
        $this->id_mapelkelas = $data->id_mapelkelas;
        $this->deskripsi = $data->deskripsi;
    }
    public function submitTugas(){
        SubmitTugas::create([
            'id_tugas' => $this->id_tugas,
            'id_user' => Auth::user()->id,
            'jawaban' => $this->jawaban
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function update(){
        $this->validate([
            'nama_tugas' => 'required',
            'id_mapelkelas' => 'required',
            'deskripsi' => 'required',
        ]);
        $data = ModelsTugas::where('id_tugas', $this->id_tugas)->update([
           'nama_tugas' => $this->nama_tugas,
            'link_youtube' => $this->link_youtube,
            'id_mapelkelas' => $this->id_mapelkelas,
            'deskripsi' => $this->deskripsi,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_tugas = $id;
    }
    public function delete(){
        ModelsTugas::where('id_tugas',$this->id_tugas)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
