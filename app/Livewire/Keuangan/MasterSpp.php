<?php

namespace App\Livewire\Keuangan;

use App\Models\master_spp;
use Livewire\Component;
use App\Models\MasterPpdb as TabelPpdb;
use App\Models\MasterSpp as ModelsMasterSpp;
use Livewire\WithPagination;

class MasterSpp extends Component
{
    public $id_spp, $kelas, $tahun, $nominal;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = ModelsMasterSpp::orderBy('id_spp','desc')->where('kelas', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.keuangan.master-spp', compact('data'));
    }
    public function insert(){
        $this->validate([
            'kelas' => 'required',
            'nominal' => 'required',
            'tahun' => 'required'
        ]);
        $data = ModelsMasterSpp::create([
            'kelas' => $this->kelas,
            'nominal' => $this->nominal,
            'tahun' => $this->tahun
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->id_spp = '';
        $this->kelas = '';
        $this->nominal = '';
        $this->tahun = '';
    }
    public function edit($id){
        $data = ModelsMasterSpp::where('id_spp', $id)->first();
        $this->id_spp = $data->id_spp;
        $this->kelas = $data->kelas;
        $this->nominal = $data->nominal;
        $this->tahun = $data->tahun;
    }
    public function update(){
        $this->validate([
            'kelas' => 'required',
            'nominal' => 'required',
            'tahun' => 'required'
        ]);
        $data = ModelsMasterSpp::where('id_spp', $this->id_spp)->update([
            'kelas' => $this->kelas,
            'nominal' => $this->nominal,
            'tahun' => $this->tahun
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_spp = $id;
    }
    public function delete(){
        ModelsMasterSpp::where('id_spp',$this->id_spp)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}

