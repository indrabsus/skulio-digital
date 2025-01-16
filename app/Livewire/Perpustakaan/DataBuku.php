<?php

namespace App\Livewire\Perpustakaan;

use Livewire\Component;
use App\Models\DataBuku as TabelBuku;
use Livewire\WithPagination;

class DataBuku extends Component
{
    public $nama_buku,
    $posisi_buku,
     $id_buku;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelBuku::orderBy('id_buku','desc')->
        where('nama_buku', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.perpustakaan.data-buku', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nama_buku' => 'required',
            'posisi_buku' => 'required'
        ]);
        $data = TabelBuku::create([
            'nama_buku' => $this->nama_buku,
            'posisi_buku' => $this->posisi_buku,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_buku = '';
        $this->posisi_buku = '';
    }
    public function edit($id){
        $data = TabelBuku::where('id_buku', $id)->first();
        $this->nama_buku = $data->nama_buku; 
        $this->posisi_buku = $data->posisi_buku; 
        $this->id_buku = $data->id_buku;
    }
    public function update(){
        $this->validate([
            'nama_buku' => 'required',
            'posisi_buku' => 'required'
        ]);
        $data = TabelBuku::where('id_buku', $this->id_buku)->update([
            'nama_buku' => $this->nama_buku,
            'posisi_buku' => $this->posisi_buku
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_buku = $id;
    }
    public function delete(){
        TabelBuku::where('id_buku',$this->id_buku)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
