<?php

namespace App\Livewire\Kurikulum;

use App\Models\JadwalPelajaran as ModelsJadwalPelajaran;
use App\Models\Kelas;
use App\Models\MapelKelas;
use App\Models\MataPelajaran;
use Livewire\Component;
use App\Models\MapelKelas as TabelMapelKelas;
use App\Models\Materi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class JadwalPelajaran extends Component
{
    public $id_mapelkelas ,$id_mapel, $id_kelas, $id_user, $semester, $materi, $konfirmasi ;
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
        $data  = MapelKelas::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('data_user','data_user.id_user','=','mapel_kelas.id_user')
        ->orderBy('kelas.tingkat','asc')
        ->orderBy('kelas.id_jurusan','asc')
        ->orderBy('kelas.nama_kelas','asc')
        ->where('hari', date('N'))
        ->where('mapel_kelas.id_user', Auth::user()->id)
        ->where('nama_pelajaran', 'like','%'.$this->cari.'%')->paginate($this->result);
        } elseif($role->nama_role == 'verifikator'){
            $ver = Kelas::where('id_user', Auth::user()->id)->first();
            $data  = MapelKelas::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('data_user','data_user.id_user','=','mapel_kelas.id_user')
        ->orderBy('kelas.tingkat','asc')
        ->orderBy('kelas.id_jurusan','asc')
        ->orderBy('kelas.nama_kelas','asc')
        ->where('hari', date('N'))
        ->where('mapel_kelas.id_kelas', $ver->id_kelas)
        // ->where('mapel_kelas.id_user', Auth::user()->id)
        ->where('nama_pelajaran', 'like','%'.$this->cari.'%')->paginate($this->result);
        }


        return view('livewire.kurikulum.jadwal-pelajaran', compact('data','mapel','kelas','guru'));
    }
    public function insert(){
        if(Auth::user()->id_role == 6){
            $this->validate([
                'id_mapel' => 'required',
                'id_kelas' => 'required',
                'tahun' => 'required',
                'aktif' => 'required',
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
                'aktif' => 'required',
                'hari' => 'required',
                'jam_awal' => 'required',
                'jam_selesai' => 'required',
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
        $this->materi = '';
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
    public function isi($id){
        $data = TabelMapelKelas::where('id_mapelkelas', $id)->first();
        $this->id_mapel = $data->id_mapel;
        $this->id_kelas = $data->id_kelas;
        $this->id_user = $data->id_user;
        $this->id_mapelkelas = $id;
        $this->tahun =  $data -> tahun;
        $this->aktif =  $data -> aktif;
    }
    public function prosesagenda(){
        $this->validate([
            'materi' => 'required',
        ]);
        $kelas = Kelas::where('id_kelas', $this->id_kelas)->first();
        $currentMonth = now()->month;

        if (in_array($currentMonth, [7, 8, 9, 10, 11, 12])) {
            $this->semester = 'ganjil';
        } else {
            $this->semester = 'genap';
        }
        $hitung = Materi::where('id_mapelkelas', $this->id_mapelkelas)
        ->whereDate('created_at', now()->format('Y-m-d'))->count();
        if($hitung > 0){
            session()->flash('gagal','Data Ganda');
        $this->clearForm();
        $this->dispatch('closeModal');
        } else {
            $data = Materi::create([
                'id_mapelkelas' => $this->id_mapelkelas,
                'materi' => $this->materi,
                'semester' => $this->semester,
                'penilaian' => 'n',
                'tingkatan' => $kelas->tingkat
            ]) ;
            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
    }

    public function konf($id){
        $data = TabelMapelKelas::where('id_mapelkelas', $id)->first();
        $this->id_mapel = $data->id_mapel;
        $this->id_kelas = $data->id_kelas;
        $this->id_user = $data->id_user;
        $this->id_mapelkelas = $id;
        $this->tahun =  $data -> tahun;
        $this->aktif =  $data -> aktif;
    }
    public function verify(){
        $this->validate([
            'konfirmasi' => 'required'
        ]);
        $kelas = Kelas::where('id_kelas', $this->id_kelas)->first();
        $currentMonth = now()->month;

        if (in_array($currentMonth, [7, 8, 9, 10, 11, 12])) {
            $this->semester = 'ganjil';
        } else {
            $this->semester = 'genap';
        }
        $cek = Materi::where('id_mapelkelas', $this->id_mapelkelas)
        ->whereDate('created_at', now()->format('Y-m-d'))->count();
        if($cek > 0){
            Materi::where('id_mapelkelas', $this->id_mapelkelas)->whereDate('created_at', now()->format('Y-m-d'))
            ->update([
                'keterangan' => $this->konfirmasi
            ]);
        } else {
            $data = Materi::create([
                'id_mapelkelas' => $this->id_mapelkelas,
                'materi' => "Tidak Mengisi AGENDA!",
                'semester' => $this->semester,
                'penilaian' => 'n',
                'tingkatan' => $kelas->tingkat,
                'keterangan' => 3
            ]) ;
        }
        session()->flash('sukses','Data berhasil dikirim');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
