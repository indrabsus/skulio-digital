<?php

namespace App\Livewire\Extend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Exam2Controller;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Setingan;
use App\Models\Sumatif;
use App\Models\User;
use Livewire\Component;
use App\Models\DataSiswa as TabelSiswa;
use App\Models\KategoriSoal;
use App\Models\MapelKelas;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class SiswaSumatif extends Component
{
    public $id_materi, $nilai, $jenkel, $id_user, $id_mapelkelas, $id_nilai, $keterangan, $waktu_agenda;
    use WithPagination;
    public $material = [];
    public $id_sumatif = '';
    public $cari_kelas ='';
    public $carisemester ='';
    public $caritahun ='';
    public $cari = '';
    public $result = 50;
    public $id_kategori = '';
    public $id_kelas = '';

    public function render()
    {
        $exam = new Exam2Controller;
        $data  = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('data_siswa','data_siswa.id_kelas','=','kelas.id_kelas')
        ->leftJoin('users','users.id','=','data_siswa.id_user')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        // ->leftJoin('materi','materi.id_mapelkelas','=','mapel_kelas.id_mapelkelas')
        ->where(function ($query) {
            $query->where('nama_lengkap', 'like', '%' . $this->cari . '%');
        })
        ->where('mapel_kelas.id_user', Auth::user()->id)
        ->where('kelas.id_kelas', $this->id_kelas)
        ->where('users.acc', 'y')
        ->orderBy('nama_lengkap','asc')
         ->paginate($this->result);

        return view('livewire.extend.siswa-sumatif', compact('exam','data'));
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
    public function chapus($id){
        $this->id_nilai = $id;
    }
    public function delete(){
        Nilai::where('id', $this->id_nilai)->delete();
        session()->flash('sukses','Data berhasil dihapus');
            $this->clearForm();
            $this->dispatch('closeModal');
    }
    public function cabsen($id, $id_materi, $waktu_agenda){
        $this->id_user = $id;
        $this->id_materi = $id_materi;
        $this->waktu_agenda = $waktu_agenda;
    }
    public function absen(){
        $this->validate([
            'keterangan' => 'required',
        ]);
        $count = AbsenSiswa::where('id_user', $this->id_user)->where('waktu', 'like','%'.date('Y-m-d',strtotime($this->waktu_agenda)).'%')->count();
        if($count > 0){
            session()->flash('gagal','Data Ganda');
            $this->clearForm();
            $this->dispatch('closeModal');
        } else {
            AbsenSiswa::create([
                'id_user' => $this->id_user,
                'keterangan' => $this->keterangan,
                'id_materi' => $this->id_materi,
                'waktu' => now()
            ]);
            session()->flash('sukses','Data berhasil ditambahkan');
                $this->clearForm();
                $this->dispatch('closeModal');
        }

    }

}
