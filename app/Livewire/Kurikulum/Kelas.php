<?php

namespace App\Livewire\Kurikulum;

use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\Setingan;
use App\Models\User;
use Livewire\Component;
use App\Models\Kelas as TabelKelas;
use Livewire\WithPagination;

class Kelas extends Component
{
    public $id_kelas, $nama_kelas, $id_jurusan, $tingkat, $id_user, $id_angkatan;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $angkatan = Angkatan::all();
        $jurusan = Jurusan::all();
        $data  = TabelKelas::leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->leftJoin('angkatan','angkatan.id_angkatan','kelas.id_angkatan')
        ->leftJoin('users','users.id','kelas.id_user')
        ->orderBy('kelas.tingkat','asc')
        ->orderBy('kelas.id_jurusan','asc')
        ->orderBy('kelas.nama_kelas','asc')
        ->where('singkatan', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.kurikulum.kelas', compact('data','jurusan','angkatan'));
    }
    public function insert(){
        $this->validate([
            'nama_kelas' => 'required',
            'id_jurusan' => 'required',
            'tingkat' => 'required',
            'id_angkatan' => 'required',
        ]);
        $set = Setingan::where('id_setingan', 1)->first();
        $user = User::create([
            'username' => rand(100000, 999999),
            'password' => bcrypt($set->default_password),
            'id_role' => 5,
            'acc' => 'y'
        ]);
        $data = TabelKelas::create([
            'nama_kelas' => $this->nama_kelas,
            'id_jurusan' => $this->id_jurusan,
            'tingkat' => $this->tingkat,
            'id_user' => $user->id,
            'id_angkatan' => $this->id_angkatan,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_kelas = '';
        $this->id_jurusan = '';
        $this->tingkat = '';
        $this->id_angkatan = '';
    }
    public function edit($id){
        $data = TabelKelas::leftJoin('angkatan','angkatan.id_angkatan','=','kelas.id_angkatan')
        ->where('id_kelas', $id)->first();
        $this->nama_kelas = $data->nama_kelas;
        $this->id_kelas = $data->id_kelas;
        $this->id_jurusan = $data->id_jurusan;
        $this->tingkat = $data->tingkat;
        $this->id_angkatan = $data->id_angkatan;
    }
    public function update(){
        $this->validate([
            'nama_kelas' => 'required',
            'id_jurusan' => 'required',
            'tingkat' => 'required',
            'id_angkatan' => 'required',
        ]);
        $data = TabelKelas::where('id_kelas', $this->id_kelas)->update([
            'nama_kelas' => $this->nama_kelas,
            'id_jurusan' => $this->id_jurusan,
            'tingkat' => $this->tingkat,
            'id_angkatan' => $this->id_angkatan,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $data = TabelKelas::where('id_kelas', $id)->first();
        $this->id_kelas = $id;
        $this->id_user = $data->id_user;
    }
    public function delete(){
        User::where('id', $this->id_user)->delete();
        TabelKelas::where('id_kelas',$this->id_kelas)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
