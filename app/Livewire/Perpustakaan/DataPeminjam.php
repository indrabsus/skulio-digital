<?php

namespace App\Livewire\Perpustakaan;

use App\Models\Kelas;
use App\Models\Angkatan;
use App\Models\Jurusan;
use Livewire\Component;
use App\Models\DataPeminjam as TabelDataPeminjam;
use Livewire\WithPagination;

class DataPeminjam extends Component
{
    public $nama_peminjam,
    $id_kelas,
    $nama_buku,
     $id_peminjam;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        $angkatan = Angkatan::all();
        $data  = TabelDataPeminjam::leftJoin('kelas','kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->leftJoin('angkatan','angkatan.id_angkatan','kelas.id_angkatan')
        ->where('nama_peminjam', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.perpustakaan.data-peminjam', compact('data','kelas','jurusan','angkatan'));
    }
    public function insert(){
        $this->validate([
            'nama_peminjam' => 'required',
            'id_kelas' => 'required',
            'nama_buku' => 'required'
        ]);
        $data = TabelDataPeminjam::create([
            'nama_peminjam' => $this->nama_peminjam,
            'id_kelas' => $this->id_kelas,
            'nama_buku' => $this->nama_buku,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_peminjam = '';
        $this->id_kelas = '';
        $this->nama_buku = '';
    }
    public function edit($id){
        $data = TabelDataPeminjam::where('id_peminjam', $id)->first();
        $this->nama_peminjam = $data->nama_peminjam; 
        $this->id_kelas = $data->id_kelas; 
        $this->nama_buku = $data->nama_buku; 
        $this->id_peminjam = $data->id_peminjam;
    }
    public function update(){
        $this->validate([
            'nama_peminjam' => 'required',
            'id_kelas' => 'required',
            'nama_buku' => 'required'
        ]);
        $data = TabelDataPeminjam::where('id_peminjam', $this->id_peminjam)->update([
            'nama_peminjam' => $this->nama_peminjam,
            'id_kelas' => $this->id_kelas,
            'nama_buku' => $this->nama_buku
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_peminjam = $id;
    }
    public function delete(){
        TabelDataPeminjam::where('id_peminjam',$this->id_peminjam)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
