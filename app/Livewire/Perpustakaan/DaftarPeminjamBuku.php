<?php

namespace App\Livewire\Perpustakaan;

use Livewire\Component;
use App\Models\DataPeminjam;
use Livewire\WithPagination;

class DaftarPeminjamBuku extends Component
{
    public $id_daftar, $updated_at, $nama_buku, $nama_lengkap, $id_siswa , $id_peminjam;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = DataPeminjam::leftJoin('data_siswa','data_siswa.id_siswa','data_peminjam.id_siswa')
        ->orderBy('id_peminjam','desc')->where('nama_buku', 'like','%'.$this->cari.'%')
        ->select('data_siswa.nama_lengkap','data_peminjam.nama_buku','data_peminjam.created_at','data_peminjam.updated_at','data_peminjam.id_peminjam')
        ->paginate($this->result);
        return view('livewire.perpustakaan.daftar-peminjam-buku', compact('data'));
    }

    public function edit($id){
        $data1 = DataPeminjam::leftJoin('data_siswa','data_siswa.id_siswa','data_peminjam.id_siswa')->where('id_peminjam', $id)->first();
        $this->nama_buku = $data1->nama_buku;
        $this->nama_lengkap = $data1->nama_lengkap;
        $this->id_peminjam = $data1->id_peminjam;
        $this->updated_at = $data1->updated_at;
    }
    public function update(){
        $this->validate([
            'nama_buku' => 'required',
            'nama_lengkap' => 'required'
        ]);
        $data = DataPeminjam::leftJoin('data_siswa','data_siswa.id_siswa','data_peminjam.id_siswa')->where('id_peminjam', $this->id_peminjam)->update([
            'nama_buku' => $this->nama_buku,
            'nama_lengkap' => $this->nama_lengkap,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function clearForm(){
        $this->nama_buku = '';
        $this->nama_lengkap = '';
    }
    public function c_delete($id){
        $this->id_peminjam = $id;
    }
    public function delete(){
        DataPeminjam::where('id_peminjam',$this->id_peminjam)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

}

