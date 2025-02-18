<?php

namespace App\Livewire\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Setingan;
use App\Models\User;
use Livewire\Component;
use App\Models\DataSiswa as TabelSiswa;
use Livewire\WithPagination;

class DataSiswaSiswi extends Component
{
    public $id_siswa, $id_user, $id_kelas, $jenkel, $no_hp, $nis, $nama_lengkap;
    use WithPagination;

    public $cari_kelas ='';
    public $cari = '';
    public $result = 10;
    public function render()
    {

        $kelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->orderBy('kelas.tingkat','asc')
        ->orderBy('kelas.id_jurusan','asc')
        ->orderBy('kelas.nama_kelas','asc')
        ->get();
        if($this->cari_kelas != ''){
        $data  = TabelSiswa::leftJoin('users','users.id','=','data_siswa.id_user')
        ->leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->orderBy('nama_lengkap','asc')
        ->where(function ($query) {
            $query->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                ->orWhere('no_hp', 'like', '%' . $this->cari . '%')
                ->orWhere('nis', 'like', '%' . $this->cari . '%');
        })
        ->where('kelas.id_kelas', $this->cari_kelas)
        ->paginate($this->result);
        } else {
            $data  = TabelSiswa::leftJoin('users','users.id','=','data_siswa.id_user')
        ->leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->orderBy('nama_lengkap','asc')
        ->where(function ($query) {
            $query->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                ->orWhere('no_hp', 'like', '%' . $this->cari . '%')
                ->orWhere('nis', 'like', '%' . $this->cari . '%');
        })
        ->paginate($this->result);
        }

        return view('livewire.kurikulum.data-siswa', compact('data','kelas'));
    }
    public function insert(){
        $this->validate([
            'id_kelas'=> 'required',
            'jenkel' => 'required',
            'no_hp'=> 'required',
            'nis'=> 'required|unique:data_siswa',
            'nama_lengkap'=> 'required',
        ]);
        $set = Setingan::where('id_setingan', 1)->first();
        $user = User::create([
            'username'=> substr(rand(100, 999).strtolower(str_replace(' ','', $this->nama_lengkap)),0,10),
            'password' => bcrypt($this->nis),
            'id_role' => 8,
            'acc' => 'y'
        ]);
        $data2 = TabelSiswa::create([
            'id_user' => $user->id,
            'nama_lengkap'=> ucwords($this->nama_lengkap),
            'jenkel'=> $this->jenkel,
            'no_hp'=> $this->no_hp,
            'nis'=> $this->nis,
            'id_kelas' => $this->id_kelas,
        ]);

        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->id_kelas = '';
        $this->nama_lengkap = '';
        $this->jenkel = '';
        $this->no_hp = '';
        $this->nis = '';
    }
    public function edit($id){
        $data = TabelSiswa::leftJoin('users','users.id','=','data_siswa.id_user')
        ->where('id_siswa', $id)->first();
        $this->nama_lengkap = $data->nama_lengkap;
        $this->jenkel = $data->jenkel;
        $this->no_hp = $data->no_hp;
        $this->nis = $data->nis;
        $this->id_user = $id;
        $this->id_kelas = $data->id_kelas;
        $this->id_siswa = $data->id_siswa;
    }
    public function update(){
        $data = TabelSiswa::leftJoin('users','users.id','=','data_siswa.id_user')
        ->where('id_siswa', $this->id_user)->first();
        if($this->nis == $data->nis){
            $this->validate([
                'id_kelas'=> 'required',
                'jenkel' => 'required',
                'no_hp'=> 'required',
                'nis'=> 'required',
                'nama_lengkap'=> 'required',
            ]);
        } else {
            $this->validate([
                'id_kelas'=> 'required',
                'jenkel' => 'required',
                'no_hp'=> 'required',
                'nis'=> 'required|unique:data_siswa',
                'nama_lengkap'=> 'required',
            ]);
        }

        User::where('id', $data->id)->update([
            'password' => bcrypt($this->nis),
        ]);
        $data = TabelSiswa::where('id_siswa', $this->id_siswa)->update([
            'nama_lengkap'=> ucwords($this->nama_lengkap),
            'jenkel'=> $this->jenkel,
            'no_hp'=> $this->no_hp,
            'nis'=> $this->nis,
            'id_kelas' => $this->id_kelas,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
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
        User::where('id_role',"8")->update([
            'acc' => 'y'
        ]);
    }
    public function disallow(){
        User::where('id_role',"8")->update([
            'acc' => 'n'
        ]);
    }
}
