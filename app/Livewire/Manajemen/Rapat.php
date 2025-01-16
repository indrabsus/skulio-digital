<?php

namespace App\Livewire\Manajemen;

use Livewire\Component;
use App\Models\BukuOnline as TabelBukuOnline;
use App\Models\Rapat as ModelsRapat;
use Livewire\WithPagination;

class Rapat extends Component
{
    public $nama_rapat,
    $link, $tanggal_rapat, $notulen,
     $id_rapat;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = ModelsRapat::orderBy('id_rapat','desc')->
        where('nama_rapat', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.manajemen.rapat', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nama_rapat' => 'required',
            'tanggal_rapat' => 'required',
        ]);
        $data = ModelsRapat::create([
            'nama_rapat' => $this->nama_rapat,
            'tanggal_rapat' => $this->tanggal_rapat,
            'notulen' => $this->notulen,
            'link' => $this->link
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_buku = '';
        $this->link_buku = '';
    }
    public function edit($id){
        $data = ModelsRapat::where('id_rapat', $id)->first();
        $this->nama_rapat = $data->nama_rapat;
        $this->link = $data->link;
        $this->id_rapat = $id;
        $this->tanggal_rapat = $data->tanggal_rapat;
        $this->notulen = $data->notulen;
    }
    public function update(){
        $this->validate([
            'nama_rapat' => 'required',
            'tanggal_rapat' => 'required'
        ]);
        $data = ModelsRapat::where('id_rapat', $this->id_rapat)->update([
            'nama_rapat' => $this->nama_rapat,
            'link' => $this->link,
            'tanggal_rapat' => $this->tanggal_rapat,
            'notulen' => $this->notulen
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_rapat = $id;
    }
    public function delete(){
        ModelsRapat::where('id_rapat',$this->id_rapat)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function notulen2($id){
        $data = ModelsRapat::where('id_rapat', $id)->first();
        $this->notulen = $data->notulen;
    }
}
