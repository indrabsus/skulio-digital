<?php

namespace App\Livewire\Kombel;

use App\Models\Kombel;
use Livewire\Component;
use App\Models\Angkatan as TabelAngkatan;
use Livewire\WithPagination;

class MasterKombel extends Component
{
    public $id_kombel, $pertemuan, $tanggal, $tema, $narasumber;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = Kombel::orderBy('pertemuan','asc')->where('tema', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.kombel.master-kombel', compact('data'));
    }
    public function insert(){
        $this->validate([
            'pertemuan' => 'required',
            'tema' => 'required',
            'narasumber' => 'required',
            'tanggal' => 'required',
        ]);
        $data = Kombel::create([
            'pertemuan' => $this->pertemuan,
            'tema' => $this->tema,
            'narasumber' => $this->narasumber,
            'tanggal' => $this->tanggal,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->pertemuan = '';
        $this->tema = '';
        $this->narasumber = '';
        $this->tanggal = '';
    }
    public function edit($id){
        $data = Kombel::where('id_kombel', $id)->first();
        $this->pertemuan = $data->pertemuan;
        $this->tema = $data->tema;
        $this->narasumber = $data->narasumber;
        $this->tanggal = $data->tanggal;
        $this->id_kombel = $data->id_kombel;
    }
    public function update(){
        $this->validate([
            'pertemuan' => 'required',
            'tema' => 'required',
            'narasumber' => 'required',
            'tanggal' => 'required',
        ]);
        $data = Kombel::where('id_kombel', $this->id_kombel)->update([
            'pertemuan' => $this->pertemuan,
            'tema' => $this->tema,
            'narasumber' => $this->narasumber,
            'tanggal' => $this->tanggal,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_kombel = $id;
    }
    public function delete(){
        Kombel::where('id_kombel',$this->id_kombel)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
