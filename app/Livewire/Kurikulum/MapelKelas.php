<?php

namespace App\Livewire\Kurikulum;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use Livewire\Component;
use App\Models\MapelKelas as TabelMapelKelas;
use Livewire\WithPagination;

class MapelKelas extends Component
{
    public $id_mapelkelas ,$id_mapel, $id_kelas ;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $kelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')->get();
        $mapel = MataPelajaran::all();
        $data  = TabelMapelKelas::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->orderBy('id_mapelkelas','desc')
        ->where('nama_pelajaran', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.kurikulum.mapel-kelas', compact('data','mapel','kelas'));
    }
    public function insert(){
        $this->validate([
            'id_mapel' => 'required',
            'id_kelas' => 'required'
        ]);
        $count = TabelMapelKelas::where('id_mapel', $this->id_mapel)->where('id_kelas', $this->id_kelas)->count();
        if($count > 0){
            session()->flash('gagal','Data Ganda');
        $this->clearForm();
        $this->dispatch('closeModal');
        } else {
            $data = TabelMapelKelas::create([
                'id_mapel' => $this->id_mapel,
                'id_kelas' => $this->id_kelas,
            ]) ;
            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
        
    }
    public function clearForm(){
        $this->id_kelas = '';
        $this->id_mapel = '';
    }
    public function edit($id){
        $data = TabelMapelKelas::where('id_mapelkelas', $id)->first();
        $this->id_mapel = $data->id_mapel; 
        $this->id_kelas = $data->id_kelas;
        $this->id_mapelkelas = $id;
    }
    public function update(){
        $this->validate([
            'id_mapel' => 'required',
            'id_kelas' => 'required'
        ]);
        $data = TabelMapelKelas::where('id_mapelkelas', $this->id_mapelkelas)->update([
            'id_mapel' => $this->id_mapel,
            'id_kelas' => $this->id_kelas,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_mapelkelas = $id;
    }
    public function delete(){
        TabelMapelKelas::where('id_mapelkelas',$this->id_mapelkelas)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}