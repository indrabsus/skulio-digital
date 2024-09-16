<?php

namespace App\Livewire\Ujian;

use App\Models\SoalUjian;
use App\Models\TampungSoal;
use Livewire\Component;
use App\Models\KategoriSoal as ModelsKategoriSoal;
use App\Models\KelasSumatif;
use App\Models\MapelKelas;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class SoalSumatif extends Component
{
    public $id_mapel, $kelas, $nama_soal, $id_kategori, $token, $tahun, $semester, $waktu, $aktif;
    use WithPagination;
    public $cari = '';
    public $centang = [];
    public $kelasku = [];
    public $result = 10;
    public $tampung = [];
    public function render()
    {
        $mapel = MapelKelas::leftJoin('mata_pelajaran', 'mata_pelajaran.id_mapel', '=', 'mapel_kelas.id_mapel')
    ->where('id_user', Auth::user()->id)
    ->distinct()
    ->get(['mapel_kelas.id_mapel', 'mata_pelajaran.nama_pelajaran']);  // Kolom yang dibutuhkan

        $data  = SoalUjian::where('nama_soal', 'like','%'.$this->cari.'%')
        ->where('id_user', Auth::user()->id)
        ->paginate($this->result);
        return view('livewire.ujian.soal-sumatif', compact('data','mapel'));
    }
    public function insert(){
        $this->validate([
            'nama_soal' => 'required',
        ]);
        $data = SoalUjian::create([
            'nama_soal' => $this->nama_soal,
            'id_user' => Auth::user()->id
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
        $this->id_kategori = $id;
    }
    public function delete(){
        ModelsKategoriSoal::where('id_kategori',$this->id_kategori)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function lihatsoal($id){
        $this->id_soalujian = $id;
        $tampung = TampungSoal::leftJoin('soal','soal.id_soal','tampung_soal.id_soal')
        ->where('id_soalujian', $this->id_soalujian)->get();
        $this->tampung = $tampung;
    }

    public function hapusTampung(){
        foreach ($this->centang as $item) {
            TampungSoal::where('id_tampung', $item)->delete();
            session()->flash('sukses', 'Soal berhasil dihapus');

            // Kosongkan form setelah sukses
            $this->clearForm();

            // Tutup modal jika ada
            $this->dispatch('closeModal');
        }

        // Flash message untuk notifikasi sukses jika tidak ada data ganda

    }
}
