<?php

namespace App\Livewire\Kurikulum;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use Livewire\Component;
use App\Models\MapelKelas as TabelMapelKelas;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class MapelKelas extends Component
{
    public $id_mapelkelas ,$id_mapel, $id_kelas, $id_user, $tahun, $aktif ;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $guru = User::leftJoin('data_user','data_user.id_user','users.id')->where('id_role',6)->get();
        $kelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->where('tingkat','<','13')
        ->orderBy('kelas.tingkat','asc')
        ->orderBy('kelas.id_jurusan','asc')
        ->orderBy('kelas.nama_kelas','asc')
        ->get();
        $mapel = MataPelajaran::all();
        $role = Role::leftJoin('users','users.id_role','roles.id_role')->where('id', Auth::user()->id)->first();
        if($role->nama_role == 'guru'){
            $data  = TabelMapelKelas::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('data_user','data_user.id_user','=','mapel_kelas.id_user')
        ->orderBy('kelas.tingkat','asc')
        ->orderBy('kelas.id_jurusan','asc')
        ->orderBy('kelas.nama_kelas','asc')
        ->where('nama_pelajaran', 'like','%'.$this->cari.'%')
        ->where('mapel_kelas.id_user', Auth::user()->id)
        ->paginate($this->result);
        } else {
            $data  = TabelMapelKelas::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
            ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->leftJoin('data_user','data_user.id_user','=','mapel_kelas.id_user')
            ->orderBy('kelas.tingkat','asc')
            ->orderBy('kelas.id_jurusan','asc')
            ->orderBy('kelas.nama_kelas','asc')
            ->where('nama_pelajaran', 'like','%'.$this->cari.'%')->paginate($this->result);
        }

        return view('livewire.kurikulum.mapel-kelas', compact('data','mapel','kelas','guru'));
    }
    public function insert(){
        if(Auth::user()->id_role == 6){
            $this->validate([
                'id_mapel' => 'required',
                'id_kelas' => 'required',
                'tahun' => 'required',
                'aktif' => 'required'
            ]);
            $count = TabelMapelKelas::where('id_mapel', $this->id_mapel)
        ->where('id_kelas', $this->id_kelas)
        ->where('tahun', $this->tahun)
        ->count();
        if($count > 0){
            session()->flash('gagal','Data Ganda');
        $this->clearForm();
        $this->dispatch('closeModal');
        } else {
            $data = TabelMapelKelas::create([
                'id_mapel' => $this->id_mapel,
                'id_kelas' => $this->id_kelas,
                'id_user' => Auth::user()->id,
                'tahun' => $this->tahun,
                'aktif' => $this->aktif
            ]) ;
            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
        } else {
            $this->validate([
                'id_mapel' => 'required',
                'id_kelas' => 'required',
                'id_user' => 'required',
                'tahun' => 'required',
                'aktif' => 'required'
            ]);
            $count = TabelMapelKelas::where('id_mapel', $this->id_mapel)
        ->where('id_kelas', $this->id_kelas)
        ->where('id_user', $this->id_user)
        ->where('tahun', $this->tahun)
        ->count();
        if($count > 0){
            session()->flash('gagal','Data Ganda');
        $this->clearForm();
        $this->dispatch('closeModal');
        } else {
            $data = TabelMapelKelas::create([
                'id_mapel' => $this->id_mapel,
                'id_kelas' => $this->id_kelas,
                'id_user' => $this->id_user,
                'tahun' => $this->tahun,
                'aktif' => $this->aktif
            ]) ;
            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
        }



    }
    public function clearForm(){
        $this->id_kelas = '';
        $this->id_mapel = '';
        $this->id_user = '';
        $this->tahun = '';
        $this->aktif = '';
    }
    public function edit($id){
        $data = TabelMapelKelas::where('id_mapelkelas', $id)->first();
        $this->id_mapel = $data->id_mapel;
        $this->id_kelas = $data->id_kelas;
        $this->id_user = $data->id_user;
        $this->id_mapelkelas = $id;
        $this->tahun =  $data -> tahun;
        $this->aktif =  $data -> aktif;
    }
    public function update(){
        $this->validate([
            'id_mapel' => 'required',
            'id_kelas' => 'required',
            'id_user' => 'required',
            'tahun' => 'required',
            'aktif' => 'required'
        ]);
        $data = TabelMapelKelas::where('id_mapelkelas', $this->id_mapelkelas)->update([
            'id_mapel' => $this->id_mapel,
            'id_kelas' => $this->id_kelas,
            'id_user' => $this->id_user,
            'tahun' => $this->tahun,
            'aktif' => $this->aktif
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_mapelkelas = $id;
    }
    public function delete(){
        TabelMapelKelas::where('id_mapelkelas',$this->id_mapelkelas)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
