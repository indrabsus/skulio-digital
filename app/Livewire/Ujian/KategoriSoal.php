<?php

namespace App\Livewire\Ujian;

use Livewire\Component;
use App\Models\KategoriSoal as ModelsKategoriSoal;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class KategoriSoal extends Component
{
    public $id_mapel, $kelas, $nama_kategori, $id_kategori;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $mapel = MataPelajaran::all();
        $data  = ModelsKategoriSoal::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','kategori_soal.id_mapel')
        ->leftJoin('data_user','data_user.id_user','kategori_soal.id_user')
        ->where('nama_kategori', 'like','%'.$this->cari.'%')
        ->paginate($this->result);
        return view('livewire.ujian.kategori-soal', compact('data','mapel'));
    }
    public function insert(){
        $this->validate([
            'nama_kategori' => 'required',
            'id_mapel' => 'required',
            'kelas' => 'required'
        ]);
        $data = ModelsKategoriSoal::create([
            'nama_kategori' => $this->nama_kategori,
            'id_mapel' => $this->id_mapel,
            'kelas' => $this->kelas,
            'id_user' => Auth::user()->id
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_kategori = '';
        $this->id_mapel = '';
        $this->kelas = '';
    }
    public function edit($id){
        $data = ModelsKategoriSoal::where('id_kategori', $id)->first();
        $this->nama_kategori = $data->nama_kategori;
        $this->id_mapel = $data->id_mapel;
        $this->kelas = $data->kelas;
        $this->id_kategori = $id;
    }
    public function update(){
        $this->validate([
            'nama_kategori' => 'required',
            'id_mapel' => 'required',
            'kelas' => 'required'
        ]);
        $data = ModelsKategoriSoal::where('id_kategori', $this->id_kategori)->update([
            'nama_kategori' => $this->nama_kategori,
            'id_mapel' => $this->id_mapel,
            'kelas' => $this->kelas,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_kategori = $id;
    }
    public function delete(){
        ModelsKategoriSoal::where('id_kategori',$this->id_kategori)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
