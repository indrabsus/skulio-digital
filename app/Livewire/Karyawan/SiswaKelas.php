<?php

namespace App\Livewire\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Setingan;
use App\Models\User;
use Livewire\Component;
use App\Models\DataSiswa as TabelSiswa;
use App\Models\MapelKelas;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class SiswaKelas extends Component
{
    public $id_materi, $nilai, $jenkel, $id_user, $id_mapelkelas, $id_nilai;
    use WithPagination;
    public $material = [];
    public $cari_kelas ='';
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $kelas = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->where('mapel_kelas.id_user', Auth::user()->id)->get();
        if($this->cari_kelas == ''){
            $data  = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('data_siswa','data_siswa.id_kelas','=','kelas.id_kelas')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->where(function ($query) {
            $query->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                ->orWhere('no_hp', 'like', '%' . $this->cari . '%')
                ->orWhere('nis', 'like', '%' . $this->cari . '%');
        })
        ->where('mapel_kelas.id_user', Auth::user()->id)
        ->paginate($this->result);
        } else {
            $data  = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('data_siswa','data_siswa.id_kelas','=','kelas.id_kelas')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->where('data_siswa.id_kelas', $this->cari_kelas)
        ->where(function ($query) {
            $query->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                ->orWhere('no_hp', 'like', '%' . $this->cari . '%')
                ->orWhere('nis', 'like', '%' . $this->cari . '%');
        })
        ->where('mapel_kelas.id_user', Auth::user()->id)
        ->paginate($this->result);
        }
        // dd($data);
        return view('livewire.karyawan.siswa-kelas', compact('data','kelas'));
    }
    public function tugas($id, $id_user){
        $this->id_materi = $id;
        $this->id_user = $id_user;
    }
    public function kirimnilai(){
        $this->validate([
            'nilai' => 'required',
        ]);
        $count = Nilai::where('id_materi', $this->id_materi)->where('id_user', $this->id_user)->count();
        if($count > 0){
            session()->flash('gagal','Data Ganda');
            $this->clearForm();
            $this->dispatch('closeModal');
        } else {
            Nilai::create([
                'id_materi' => $this->id_materi,
                'nilai' => $this->nilai,
                'id_user' => $this->id_user,
            ]);

            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
    }
    public function clearForm(){
        $this->nilai = '';
    }

}
