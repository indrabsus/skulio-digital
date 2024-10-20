<?php

namespace App\Livewire\Ujian;

use App\Models\DataSiswa;
use App\Models\SoalUjian;
use App\Models\TampungSoal;
use Livewire\Component;
use App\Models\KategoriSoal as ModelsKategoriSoal;
use App\Models\KelasSumatif;
use App\Models\MapelKelas;
use App\Models\MataPelajaran;
use App\Models\Sumatif as ModelsSumatif;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Sumatif extends Component
{
    public $nama_sumatif, $id_sumatif, $token, $tahun, $waktu, $kelas, $id_soalujian;
    use WithPagination;

    public $cari = '';
    public $kelasku = [];
    public $result = 10;
    public function render()
    {
        $mapel = MapelKelas::leftJoin('mata_pelajaran', 'mata_pelajaran.id_mapel', '=', 'mapel_kelas.id_mapel')
    ->where('id_user', Auth::user()->id)
    ->distinct()
    ->get(['mapel_kelas.id_mapel', 'mata_pelajaran.nama_pelajaran']);  // Kolom yang dibutuhkan
        $tampung = SoalUjian::where('id_user',Auth::user()->id)->get();
        if(Auth::user()->id_role == 8){
        $aku = DataSiswa::where('id_user', Auth::user()->id)->first();
        $data  = ModelsSumatif::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','sumatif.id_mapelkelas')
        ->leftJoin('soal_ujian','soal_ujian.id_soalujian','sumatif.id_soalujian')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->where('nama_sumatif', 'like','%'.$this->cari.'%')
        ->where('mapel_kelas.id_kelas', $aku->id_kelas)
        ->paginate($this->result);
        } else {
        $data  = ModelsSumatif::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','sumatif.id_mapelkelas')
        ->leftJoin('soal_ujian','soal_ujian.id_soalujian','sumatif.id_soalujian')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->where('nama_sumatif', 'like','%'.$this->cari.'%')
        ->paginate($this->result);
        }
        return view('livewire.ujian.sumatif', compact('data','mapel', 'tampung'));
    }
    public function insert(){
        $this->validate([
            'nama_sumatif' => 'required',
            'token' => 'required',
            'waktu' => 'required',
            'tahun' => 'required',
            'kelasku' => 'required',
            'id_soalujian' => 'required'
        ]);
        // $data = ModelsSumatif::create([
        //     'nama_sumatif' => $this->nama_sumatif,
        //     'token' => $this->token,
        //     'waktu' => $this->waktu,
        //     'tahun' => $this->tahun,
        // ]) ;
        // session()->flash('sukses','Data berhasil ditambahkan');
        // $this->clearForm();
        // $this->dispatch('closeModal');


        $isDuplicate = false;

        foreach ($this->kelasku as $id_mapelkelas) {
            $exists = ModelsSumatif::where('id_mapelkelas', $id_mapelkelas)
                                  ->where('id_sumatif', $this->id_sumatif)
                                  ->exists();

            if (!$exists) {
                $data = ModelsSumatif::create([
                    'nama_sumatif' => $this->nama_sumatif,
                    'id_soalujian' => $this->id_soalujian,
                    'id_mapelkelas' => $id_mapelkelas,
                    'token' => $this->token,
                    'waktu' => $this->waktu,
                    'tahun' => $this->tahun,
                ]) ;
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
        $data = ModelsSumatif::where('id_sumatif', $id)->first();
        $this->nama_sumatif = $data->nama_sumatif;
        $this->id_sumatif = $id;
        $this->waktu = $data->waktu;
        $this->token = $data->token;
        $this->tahun = $data->tahun;
    }
    public function update(){
        $this->validate([
            'nama_sumatif' => 'required',
            'token' => 'required',
            'waktu' => 'required',
            'tahun' => 'required',
        ]);
        $data = ModelsSumatif::where('id_sumatif', $this->id_sumatif)->update([
            'nama_sumatif' => $this->nama_sumatif,
            'token' => $this->token,
            'waktu' => $this->waktu,
            'tahun' => $this->tahun,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_sumatif = $id;
    }
    public function delete(){
        ModelsSumatif::where('id_sumatif',$this->id_sumatif)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
