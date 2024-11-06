<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use App\Models\BukuOnline as TabelBukuOnline;
use App\Models\Masukan;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Intervention\Image\Facades\Image;
use Livewire\WithFileUploads;

class MasukanSiswa extends Component
{
    use WithFileUploads;
    public $masukan,
    $kategori,
     $id_masukan, $gambar, $gambar2;
     public $anonim = false;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        if(Auth::user()->id_role == 8){
            $data  = Masukan::orderBy('created_at','desc')
            ->where('masukan', 'like','%'.$this->cari.'%')
            ->where('id_user', Auth::user()->id)
            ->paginate($this->result);
        } else {
            $data  = Masukan::orderBy('created_at','desc')
            ->where('masukan', 'like','%'.$this->cari.'%')
            ->paginate($this->result);
        }

        return view('livewire.siswa.masukan-siswa', compact('data'));
    }
    public function c_status($id){
        $data = Masukan::where('id_masukan', $id)->first();
        if($data->status == '0'){
            $data->update([
                'status' => '1'
            ]);
        } elseif($data->status == '1'){
            $data->update([
                'status' => '2'
            ]);
        } else {
            $data->update([
                'status' => '0'
            ]);
        }
        session()->flash('sukses','Status berhasil diubah');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function lihat($id){
        $data = Masukan::where('id_masukan', $id)->first();
        $this->gambar2 = $data->gambar;
    }
    public function insert(){
        $this->validate([
            'masukan' => 'required',
            'kategori' => 'required',
            'gambar' => 'nullable|image|max:5024',
        ]);
        $imageName = null;
        if ($this->gambar) {
            // Compress the image
            $image = Image::make($this->gambar->getRealPath());
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75); // 75 is the quality percentage

            // Save the compressed image
            $imageName = 'layanan/' . uniqid() . '.jpg';
            \Storage::disk('public')->put($imageName, (string) $image);
        }
        $data = Masukan::create([
            'masukan' => $this->masukan,
            'id_user' => Auth::user()->id,
            'kategori' => $this->kategori,
            'gambar' => $imageName,
            'anonim' => $this->anonim == true ? 'y' : 'n',
            'status' => '0'
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_buku = '';
        $this->link_buku = '';
    }
    public function edit($id){
        $data = TabelBukuOnline::where('id_buku_online', $id)->first();
        $this->nama_buku = $data->nama_buku;
        $this->link_buku = $data->link_buku;
        $this->id_buku_online = $data->id_buku_online;
    }
    public function update(){
        $this->validate([
            'nama_buku' => 'required',
            'link_buku' => 'required'
        ]);
        $data = TabelBukuOnline::where('id_buku_online', $this->id_buku_online)->update([
            'nama_buku' => $this->nama_buku,
            'link_buku' => $this->link_buku
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_masukan = $id;
    }
    public function delete(){
        $data = Masukan::find($this->id_masukan);

        if ($data) {
            // Hapus gambar jika ada
            if ($data->gambar && \Storage::disk('public')->exists($data->gambar)) {
                \Storage::disk('public')->delete($data->gambar);
            }

            // Hapus data soal
            $data->delete();

            session()->flash('sukses', 'Data berhasil dihapus');
            $this->clearForm();
        $this->dispatch('closeModal');
        } else {
            session()->flash('error', 'Data tidak ditemukan');
            $this->clearForm();
        $this->dispatch('closeModal');
        }
    }
}
