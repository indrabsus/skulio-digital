<?php

namespace App\Livewire\Humas;

use App\Models\Kelas;
use App\Models\Angkatan;
use App\Models\Jurusan;
use Livewire\Component;
use App\Models\DataPkl;
use App\Models\DataSiswa;
use App\Models\DataUser;
use App\Models\TempatPkl;
use Livewire\WithPagination;

class SiswaPkl extends Component
{
    public $id_siswa, $id_pembimbing, $id_observer, $waktu_mulai, $waktu_selesai, $tahun, $nama_lengkap,$id_tempat;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function mount()
    {
        $this->tahun = date('Y');
    }
    public function render()
    {
        $tempat = TempatPkl::all();
        $guru = DataUser::leftJoin('users','users.id','data_user.id_user')->where('id_role', 6)->get();
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        $angkatan = Angkatan::all();
        $data  = DataSiswa::leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->orderBy('id_siswa','desc')
        ->where('nama_lengkap', 'like','%'.$this->cari.'%')
        ->where('kelas.tingkat', 12)
        ->paginate($this->result);
        return view('livewire.humas.siswa-pkl', compact('data','kelas','jurusan','angkatan','guru','tempat'));
    }

    public function clearForm(){
        $this->id_siswa = '';
        $this->id_pembimbing = '';
        $this->id_observer = '';
        $this->tahun = '';
        $this->waktu_mulai = '';
        $this->waktu_selesai = '';
        $this->id_tempat = '';
    }
    public function pkl($id){
        $data = DataSiswa::where('id_siswa',$id)->first();
        $this->id_siswa = $id;
        $this->nama_lengkap = $data->nama_lengkap;
    }
    public function prosesPkl(){
        $this->validate([
            'id_pembimbing' => 'required',
            'id_observer' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tahun' => 'required',
            'id_tempat' => 'required',
        ]);
        $count = DataPkl::where('id_siswa', $this->id_siswa)->count();
        if($count > 0){
            session()->flash('gagal','Data sudah ada');
            $this->clearForm();
            $this->dispatch('closeModal');
        } else {
            DataPkl::create([
                'id_siswa' => $this->id_siswa,
                'id_pembimbing' => $this->id_pembimbing,
                'id_observer' => $this->id_observer,
                'waktu_mulai' => $this->waktu_mulai,
                'waktu_selesai' => $this->waktu_selesai,
                'tahun' => $this->tahun,
                'id_tempat' => $this->id_tempat
            ]);
            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }

    }
}
