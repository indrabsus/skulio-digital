<?php

namespace App\Livewire\Kurikulum;

use App\Models\AbsenHarianSiswa;
use Livewire\Component;
use Livewire\WithPagination;

class AbsenHarian extends Component
{
    public $id_role, $id_harian, $nama_lengkap, $jenkel, $no_hp, $alamat, $id_user, $status, $waktu;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = AbsenHarianSiswa::where('nama_lengkap', 'like','%'.$this->cari.'%')
        ->leftJoin('data_siswa','data_siswa.id_siswa','=','absen_harian_siswa.id_siswa')
        ->leftJoin(('kelas'),'kelas.id_kelas','=','data_siswa.id_kelas')
        ->leftJoin(('jurusan'),'jurusan.id_jurusan','=','kelas.id_jurusan')
        ->orderBy('absen_harian_siswa.created_at','desc')
        ->select('absen_harian_siswa.*','data_siswa.nama_lengkap','kelas.tingkat','kelas.nama_kelas','jurusan.singkatan')
        ->paginate($this->result);
        return view('livewire.kurikulum.absen-harian', compact('data',));
    }

    public function c_delete($id){
        $this->id_harian = $id;
    }
    public function delete(){
        AbsenHarianSiswa::where('id_harian',$this->id_harian)->delete();

        session()->flash('sukses','Data berhasil dihapus');
        $this->dispatch('closeModal');
    }
}
