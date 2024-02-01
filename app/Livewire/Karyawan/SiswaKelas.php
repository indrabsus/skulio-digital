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
    public $id_materi, $nilai, $jenkel, $id_user, $id_mapelkelas;
    use WithPagination;
    public $material = [];
    public $cari_kelas ='';
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $kelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')->get();
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
        // dd($data);
        return view('livewire.karyawan.siswa-kelas', compact('data','kelas'));
    }
    public function tugas($id,$id_user){
        $this->id_mapelkelas = $id;
        $this->id_user = $id_user;
    }
    public function kirimnilai(){
        $this->validate([
            'id_materi'=> 'required',
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
        $this->id_materi = '';
        $this->nilai = '';
    }

    public function c_delete($id){
        $this->id_user = $id;
    }
    public function delete(){
        User::where('id', $this->id_user)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function c_reset($id){
        $data = TabelSiswa::where('id_user', $id)->first();
        $this->nis = $data->nis;
        $this->id_user = $id;
    }
    public function p_reset(){
        // $set = new Controller;
        // $set->resetPass($this->id_user);
        User::where('id', $this->id_user)->update([
            'password'=> bcrypt($this->nis),
        ]);
        session()->flash('sukses','Password berhasil direset');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function ubahAcc($id){
        $user = User::where('id', $id)->first();
        if($user->acc == 'n'){
            User::where('id',$id)->update([
                'acc' => 'y'
            ]);
        } else {
            User::where('id',$id)->update([
                'acc' => 'n'
            ]);
        }
    }

    public function allow(){
        User::where('id_role',8)->update([
            'acc' => 'y'
        ]);
    }
    public function disallow(){
        User::where('id_role',8)->update([
            'acc' => 'n'
        ]);
    }
}
