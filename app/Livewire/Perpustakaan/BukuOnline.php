<?php

namespace App\Livewire\Perpustakaan;

use Livewire\Component;
use App\Models\BukuOnline as TabelBukuOnline;
use Livewire\WithPagination;

class BukuOnline extends Component
{
    public $nama_buku,
    $link_buku,
     $id_buku_online;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelBukuOnline::orderBy('id_buku_online','desc')->
        where('nama_buku', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.perpustakaan.buku-online', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nama_buku' => 'required',
            'link_buku' => 'required'
        ]);
        $data = TabelBukuOnline::create([
            'nama_buku' => $this->nama_buku,
            'link_buku' => $this->link_buku,
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
        $data = TabelBukuOnline::where('id_buku_online', $id)->first();
        $this->nama_buku = $data->nama_buku; 
        $this->link_buku = $data->link_buku; 
        $this->id_buku_online = $data->id_buku_online;
    }
    public function update(){
        $this->validate([
            'nama_buku' => 'required',
            'link_buku' => 'required'
        ]);
        $data = TabelBukuOnline::where('id_buku_online', $this->id_buku_online)->update([
            'nama_buku' => $this->nama_buku,
            'link_buku' => $this->link_buku
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_buku_online = $id;
    }
    public function delete(){
        TabelBukuOnline::where('id_buku_online',$this->id_buku_online)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
