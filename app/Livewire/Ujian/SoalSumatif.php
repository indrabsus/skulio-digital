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
    public $id_soalujian;
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
        ->orderBy('soal_ujian.created_at', 'desc')
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
        $data = SoalUjian::where('id_soalujian', $id)->first();
        $this->nama_soal = $data->nama_soal;
        $this->id_soalujian = $id;
    }
    public function update(){
        $this->validate([
            'nama_soal' => 'required',
        ]);
        $data = SoalUjian::where('id_soalujian', $this->id_soalujian)->update([
            'nama_soal' => $this->nama_soal,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_soalujian = $id;
    }
    public function delete(){
        SoalUjian::where('id_soalujian',$this->id_soalujian)->delete();
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
