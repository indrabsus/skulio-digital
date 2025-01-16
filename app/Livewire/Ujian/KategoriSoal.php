<?php

namespace App\Livewire\Ujian;

use Livewire\Component;
use App\Models\KategoriSoal as ModelsKategoriSoal;
use App\Models\KelasSumatif;
use App\Models\MapelKelas;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class KategoriSoal extends Component
{
    public $id_mapel, $kelas, $nama_kategori, $id_kategori, $token, $tahun, $semester, $waktu, $aktif;
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

        $data  = ModelsKategoriSoal::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','kategori_soal.id_mapel')
        ->leftJoin('data_user','data_user.id_user','kategori_soal.id_user')
        ->where('nama_kategori', 'like','%'.$this->cari.'%')
        ->paginate($this->result);
        return view('livewire.ujian.kategori-soal', compact('data','mapel'));
    }
    public function insert(){
        $this->validate([
            'nama_kategori' => 'required',
            'id_mapel' => 'required'
        ]);
        $data = ModelsKategoriSoal::create([
            'nama_kategori' => $this->nama_kategori,
            'id_mapel' => $this->id_mapel,
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
        $this->id_kategori = $id;
    }
    public function update(){
        $this->validate([
            'nama_kategori' => 'required',
            'id_mapel' => 'required'
        ]);
        $data = ModelsKategoriSoal::where('id_kategori', $this->id_kategori)->update([
            'nama_kategori' => $this->nama_kategori,
            'id_mapel' => $this->id_mapel
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
}
