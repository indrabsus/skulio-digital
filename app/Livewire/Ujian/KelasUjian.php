<?php

namespace App\Livewire\Ujian;

use App\Models\DataSiswa;
use Livewire\Component;
use App\Models\KategoriSoal as ModelsKategoriSoal;
use App\Models\KelasSumatif;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class KelasUjian extends Component
{
    public $id_kelassumatif, $kelas, $nama_kategori, $id_kategori, $token, $tahun, $semester, $waktu, $aktif;
    use WithPagination;

    public $cari = '';
    public $kelasku = [];
    public $result = 10;
    public function render()
    {
        $kls = DataSiswa::where('id_user', Auth::user()->id)->first();
        $mapel = MataPelajaran::all();
        if(Auth::user()->id_role == 8){
            $data  = KelasSumatif::leftJoin('kategori_soal','kategori_soal.id_kategori','kelas_sumatif.id_kategori')
            ->leftJoin('kelas','kelas.id_kelas','kelas_sumatif.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','kategori_soal.id_mapel')
            ->where('kelas.id_kelas', $kls->id_kelas)
            ->where('nama_kategori', 'like','%'.$this->cari.'%')
            ->paginate($this->result);
            return view('livewire.ujian.kelas-ujian', compact('data','mapel'));
        } else {
            $data  = KelasSumatif::leftJoin('kategori_soal','kategori_soal.id_kategori','kelas_sumatif.id_kategori')
            ->leftJoin('kelas','kelas.id_kelas','kelas_sumatif.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','kategori_soal.id_mapel')
            ->where('nama_kategori', 'like','%'.$this->cari.'%')
            ->paginate($this->result);
            return view('livewire.ujian.kelas-ujian', compact('data','mapel'));
        }

    }
    public function insert(){
        $this->validate([
            'nama_kategori' => 'required',
            'id_mapel' => 'required',
            'kelas' => 'required',
            'waktu' => 'required',
            'token' => 'required',
            'semester' => 'required',
            'tahun' => 'required',
            'aktif' => 'required'
        ]);
        $data = ModelsKategoriSoal::create([
            'nama_kategori' => $this->nama_kategori,
            'id_mapel' => $this->id_mapel,
            'kelas' => $this->kelas,
            'id_user' => Auth::user()->id,
            'waktu' => $this->waktu,
            'token' => $this->token,
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'aktif' => 'y'
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_kelas($id){
        $this->clearForm();
        $this->dispatch('openModal');
        $data = ModelsKategoriSoal::where('id_kategori', $id)->first();
        $this->kelas = $data->kelas;
        $this->id_kategori = $id;
    }
    public function ujiankelas() {
        $input = $this->validate([
            'kelasku' => 'required',
        ]);

        $isDuplicate = false;

        foreach ($this->kelasku as $id_kelas) {
            $exists = KelasSumatif::where('id_kelas', $id_kelas)
                                  ->where('id_kategori', $this->id_kategori)
                                  ->exists();

            if (!$exists) {
                KelasSumatif::create([
                    'id_kelas' => $id_kelas,
                    'id_kategori' => $this->id_kategori,
                ]);
            } else {
                $isDuplicate = true;
                break; // Menghentikan loop jika ada data ganda
            }
        }

        if ($isDuplicate) {
            session()->flash('gagal', 'Data dengan kelas dan kategori ini sudah ada.');
        } else {
            session()->flash('sukses', 'Data berhasil ditambahkan');
        }

        $this->clearForm();
        $this->dispatch('closeModal');
    }


    public function clearForm(){
        $this->kelasku = [];
    }
    public function edit($id){
        $data = ModelsKategoriSoal::where('id_kategori', $id)->first();
        $this->nama_kategori = $data->nama_kategori;
        $this->id_mapel = $data->id_mapel;
        $this->kelas = $data->kelas;
        $this->id_kategori = $id;
        $this->waktu = $data->waktu;
        $this->token = $data->token;
        $this->semester = $data->semester;
        $this->tahun = $data->tahun;
        $this->aktif = $data->aktif;
    }
    public function update(){
        $this->validate([
            'nama_kategori' => 'required',
            'id_mapel' => 'required',
            'kelas' => 'required',
            'waktu' => 'required',
            'token' => 'required',
            'semester' => 'required',
            'tahun' => 'required',
            'aktif' => 'required'
        ]);
        $data = ModelsKategoriSoal::where('id_kategori', $this->id_kategori)->update([
            'nama_kategori' => $this->nama_kategori,
            'id_mapel' => $this->id_mapel,
            'kelas' => $this->kelas,
            'waktu' => $this->waktu,
            'token' => $this->token,
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'aktif' => $this->aktif
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_kelassumatif = $id;
    }
    public function delete(){
        KelasSumatif::where('id_kelassumatif',$this->id_kelassumatif)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
