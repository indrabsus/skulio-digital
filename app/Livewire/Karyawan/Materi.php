<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use App\Models\BukuOnline as TabelBukuOnline;
use App\Models\Kelas;
use App\Models\MapelKelas;
use App\Models\Materi as ModelsMateri;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Materi extends Component
{
    public $materi, $id_mapelkelas,$id_materi, $semester, $tahun_pelajaran, $tingkatan, $penilaian, $konfirmasi;
    use WithPagination;
    public $carisemester = '';
    public $caritahun = '';
    public $cari = '';
    public $result = 10;
    public function render()
    {
        if(Auth::user()->id_role == 5){
        $aku = Kelas::where('id_user', Auth::user()->id)->first();
        $mapelv = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('data_user','data_user.id_user','mapel_kelas.id_user')
        ->where('mapel_kelas.id_kelas', $aku->id_kelas)
        ->where('aktif', 'y')
        ->get();
        }
        $mapelkelas = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->where('mapel_kelas.id_user',Auth::user()->id)
        ->where('aktif', 'y')
        ->where('kelas.tingkat', $this->tingkatan)
        ->get();

        if(Auth::user()->id_role == 5){
        $data  = ModelsMateri::orderBy('id_materi','desc')
        ->leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
        ->leftJoin('data_user','data_user.id_user','mapel_kelas.id_user')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->where('kelas.id_kelas', $aku->id_kelas)
        ->select('tahun','tahun_pelajaran','semester','materi.materi','materi.id_materi','kelas.nama_kelas','singkatan','tingkat','materi.created_at','nama_pelajaran','tingkatan','penilaian','nama_lengkap','keterangan')
        ->where('materi', 'like','%'.$this->cari.'%')
        ->where('tahun_pelajaran', 'like','%'.$this->caritahun.'%')
        ->where('semester', 'like','%'.$this->carisemester.'%')
        ->paginate($this->result);

        }
        elseif(Auth::user()->id_role != 6){
            $data  = ModelsMateri::orderBy('id_materi','desc')
            ->leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
            ->leftJoin('data_user','data_user.id_user','mapel_kelas.id_user')
            ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
            ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->select('tahun','tahun_pelajaran','semester','materi.materi','materi.id_materi','kelas.nama_kelas','singkatan','tingkat','materi.created_at','nama_pelajaran','tingkatan','penilaian','nama_lengkap','keterangan')
            ->where('materi', 'like','%'.$this->cari.'%')
            ->where('tahun_pelajaran', 'like','%'.$this->caritahun.'%')
            ->where('semester', 'like','%'.$this->carisemester.'%')
            ->paginate($this->result);
        }
        else {
            $data  = ModelsMateri::orderBy('id_materi','desc')
        ->leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->where('mapel_kelas.id_user',Auth::user()->id)
        ->select('tahun','tahun_pelajaran','semester','materi.materi','materi.id_materi','kelas.nama_kelas','singkatan','tingkat','materi.created_at','nama_pelajaran','tingkatan','penilaian','nama_lengkap')
        ->where('materi', 'like','%'.$this->cari.'%')
        ->where('tahun_pelajaran', 'like','%'.$this->caritahun.'%')
        ->where('semester', 'like','%'.$this->carisemester.'%')
        ->paginate($this->result);
        }
        if(Auth::user()->id_role == 5){
            return view('livewire.karyawan.materi', compact('data','mapelkelas','mapelv'));
        } else {
            return view('livewire.karyawan.materi', compact('data','mapelkelas'));
        }
    }
    public function insert(){
        $this->validate([
            'materi' => 'required',
            'id_mapelkelas' => 'required',
            'semester' => 'required',
            'tingkatan' => 'required',
            'penilaian' => 'required',
        ]);
        $tahun = MapelKelas::where('id_mapelkelas', $this->id_mapelkelas)->first();
        $data = ModelsMateri::create([
            'materi' => $this->materi,
            'id_mapelkelas' => $this->id_mapelkelas,
            'semester' => $this->semester,
            'tahun_pelajaran' => $tahun->tahun,
            'tingkatan' => $this->tingkatan,
            'penilaian' => $this->penilaian
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->materi = '';
        $this->id_mapelkelas = '';
        $this->semester = '';
        $this->tingkatan = '';
        $this->penilaian = '';
    }
    public function edit($id){
        $data = ModelsMateri::where('id_materi', $id)->first();
        $this->materi = $data->materi;
        $this->id_mapelkelas = $data->id_mapelkelas;
        $this->semester = $data->semester;
        $this->tahun_pelajaran = $data->tahun_pelajaran;
        $this->tingkatan = $data->tingkatan;
        $this->penilaian = $data->penilaian;
        $this->id_materi = $id;
    }
    public function update(){
        $this->validate([
            'materi' => 'required',
            'id_mapelkelas' => 'required',
            'semester' => 'required',
            'tahun_pelajaran' => 'required',
            'tingkatan' => 'required',
            'penilaian' => 'required',
        ]);
        $data = ModelsMateri::where('id_materi', $this->id_materi)->update([
            'materi' => $this->materi,
            'id_mapelkelas' => $this->id_mapelkelas,
            'semester' => $this->semester,
            'tahun_pelajaran' => $this->tahun_pelajaran,
            'tingkatan' => $this->tingkatan,
            'penilaian' => $this->penilaian

        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_materi = $id;
    }
    public function delete(){
        ModelsMateri::where('id_materi',$this->id_materi)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function konf($id){
        $this->id_materi = $id;
    }
    public function verify(){
        $this->validate([
            'konfirmasi' => 'required'
        ]);
        ModelsMateri::where('id_materi', $this->id_materi)->update([
            'keterangan' => $this->konfirmasi
        ]);
        session()->flash('sukses','Data berhasil dikirim');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function insertagenda(){
        $this->validate([
            'semester' => 'required',
            'id_mapelkelas' => 'required',
        ]);
        $hitung = ModelsMateri::where('id_mapelkelas', $this->id_mapelkelas)
        ->whereDate('created_at', now()->format('Y-m-d'))
        ->count();

        $aku = Kelas::where('id_user', Auth::user()->id)->first();
        $tahun = MapelKelas::where('id_mapelkelas', $this->id_mapelkelas)->first();
        if($hitung > 0){
            session()->flash('gagal','Data Ganda');
            $this->clearForm();
            $this->dispatch('closeModal');
        } else {
            ModelsMateri::create([
                'id_mapelkelas' => $this->id_mapelkelas,
                'semester' => $this->semester,
                'materi' => 'Diisi oleh SISTEM',
                'tahun_pelajaran' => $tahun->tahun,
                'penilaian' => 'n',
                'tingkatan' => $aku->tingkat,
                'keterangan' => 3
            ]);
            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }

    }
}
