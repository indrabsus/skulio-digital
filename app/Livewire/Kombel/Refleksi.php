<?php

namespace App\Livewire\Kombel;

use App\Models\Kombel;
use Livewire\Component;
use App\Models\Angkatan as TabelAngkatan;
use App\Models\Refleksi as ModelsRefleksi;
use Livewire\WithPagination;

class Refleksi extends Component
{
    public $id_refleksi, $pertanyaan, $id_kombel;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $kombel = Kombel::all();
        $data  = ModelsRefleksi::leftJoin('kombel','kombel.id_kombel','refleksi.id_kombel')->orderBy('id_refleksi','desc')->where('pertemuan', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.kombel.refleksi', compact('data','kombel'));
    }
    public function insert(){
        $this->validate([
            'id_kombel' => 'required',
            'pertanyaan' => 'required',
        ]);
        $data = ModelsRefleksi::create([
            'id_kombel' => $this->id_kombel,
            'pertanyaan' => $this->pertanyaan,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->id_kombel = '';
        $this->pertanyaan = '';
    }
    public function edit($id){
        $data = ModelsRefleksi::where('id_refleksi', $id)->first();
        $this->id_kombel = $data->id_kombel;
        $this->pertanyaan = $data->pertanyaan;
    }
    public function update(){
        $this->validate([
            'id_kombel' => 'required',
            'pertanyaan' => 'required',
        ]);
        $data = ModelsRefleksi::where('id_refleksi', $this->id_refleksi)->update([
            'id_kombel' => $this->id_kombel,
            'pertanyaan' => $this->pertanyaan,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_refleksi = $id;
    }
    public function delete(){
        Kombel::where('id_refleksi',$this->id_refleksi)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
