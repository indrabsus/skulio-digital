<?php

namespace App\Livewire\Perpustakaan;

use App\Models\Kelas;
use App\Models\Angkatan;
use App\Models\Jurusan;
use Livewire\Component;
use App\Models\DataPeminjam as TabelDataPeminjam;
use App\Models\DataSiswa;
use Livewire\WithPagination;

class DataPeminjam extends Component
{
    public $id_siswa,
    $nama_buku;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        $angkatan = Angkatan::all();
        $data  = DataSiswa::leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->where('nama_lengkap', 'like','%'.$this->cari.'%')
        ->paginate($this->result);
        return view('livewire.perpustakaan.data-peminjam', compact('data','kelas','jurusan','angkatan'));
    }

    public function clearForm(){
        $this->nama_buku = '';
    }
    public function pinjam($id){
        $this->id_siswa = $id;
    }
    public function prosesPinjam(){
        $this->validate([
            'nama_buku' => 'required'
        ]);
        TabelDataPeminjam::create([
            'id_siswa' => $this->id_siswa,
            'nama_buku' => $this->nama_buku,
            'tanggal_pinjam' => date('Y-m-d H:i:s'),
            'kembali' => 'n'
        ]);
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
