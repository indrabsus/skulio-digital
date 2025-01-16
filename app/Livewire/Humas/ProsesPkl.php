<?php

namespace App\Livewire\Humas;

use App\Models\Kelas;
use App\Models\Angkatan;
use App\Models\Jurusan;
use Livewire\Component;
use App\Models\DataPkl;
use App\Models\DataSiswa;
use App\Models\DataUser;
use Livewire\WithPagination;

class ProsesPkl extends Component
{
    public $id_siswa, $id_pembimbing, $id_observer, $waktu_mulai, $waktu_selesai, $tahun, $nama_lengkap, $id_pkl;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $guru = DataUser::leftJoin('users','users.id','data_user.id_user')
        ->where('id_role', 6)->get();
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        $angkatan = Angkatan::all();
        $data = DataPkl::leftJoin('data_siswa', 'data_siswa.id_siswa', 'data_pkl.id_siswa')
    ->leftJoin('kelas', 'kelas.id_kelas', 'data_siswa.id_kelas')
    ->leftJoin('jurusan', 'jurusan.id_jurusan', 'kelas.id_jurusan')
    ->leftJoin('data_user as pembimbing', 'pembimbing.id_data', 'data_pkl.id_pembimbing')
    ->leftJoin('data_user as observer', 'observer.id_data', 'data_pkl.id_observer')
    ->leftJoin('tempat_pkl', 'tempat_pkl.id_tempat', 'data_pkl.id_tempat')
    ->select(
        'data_siswa.nama_lengkap as nama_siswa',
        'observer.nama_lengkap as nama_observer',
        'pembimbing.nama_lengkap as nama_pembimbing',
        'data_pkl.tahun', 'data_pkl.waktu_mulai', 'data_pkl.waktu_selesai',
        'kelas.tingkat', 'jurusan.singkatan', 'kelas.nama_kelas', 'data_siswa.no_hp','id_pkl', 'tempat_pkl'
    )
    ->where(function ($query) {
        $query->where('data_siswa.nama_lengkap', 'like', '%' . $this->cari . '%')
              ->orWhere('observer.nama_lengkap', 'like', '%' . $this->cari . '%')
              ->orWhere('pembimbing.nama_lengkap', 'like', '%' . $this->cari . '%')
              ->orWhere('tempat_pkl', 'like', '%' . $this->cari . '%');
    })
    ->orderBy('data_pkl.created_at', 'desc')
    ->paginate($this->result);


        // dd($data);
        return view('livewire.humas.proses-pkl', compact('data','kelas','jurusan','angkatan','guru'));
    }

    public function clearForm(){
        $this->id_siswa = '';
        $this->id_pembimbing = '';
        $this->id_observer = '';
        $this->tahun = '';
        $this->waktu_mulai = '';
        $this->waktu_selesai = '';
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
                'tahun' => $this->tahun
            ]);
            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }

    }
    public function c_delete($id){
        $this->id_pkl = $id;
    }
    public function delete(){
        DataPkl::where('id_pkl',$this->id_pkl)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
