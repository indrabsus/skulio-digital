<?php

namespace App\Livewire\Ujian;

use Livewire\Component;
use App\Models\KategoriSoal as ModelsKategoriSoal;
use App\Models\MataPelajaran;
use App\Models\Soal as ModelsSoal;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\Facades\Image;

class Soal extends Component
{
    public $id_mapel, $kelas, $nama_kategori, $id_soal;
    public $id_kategori;
    public $gambar;
    public $soal;
    public $pilihan_a;
    public $pilihan_b;
    public $pilihan_c;
    public $pilihan_d;
    public $pilihan_e;
    public $jawaban;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    use WithFileUploads;
    public function mount()
    {
        $this->id_kategori = request()->query('id_kategori');
    }
    public function render()
    {
        $kategori = ModelsKategoriSoal::where('id_user', Auth::user()->id)->get();
        $mapel = MataPelajaran::all();
        $data  = ModelsSoal::leftJoin('kategori_soal','kategori_soal.id_kategori','kategori_soal.id_kategori')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','kategori_soal.id_mapel')
        ->where('soal', 'like','%'.$this->cari.'%')
        ->orderBy('id_soal','desc')
        ->paginate($this->result);
        return view('livewire.ujian.soal', compact('data','mapel','kategori'));
    }
    public function insert(){
        $this->validate([
        'gambar' => 'nullable|image|max:5024',
        'soal' => 'required|string',
        'pilihan_a' => 'required|string',
        'pilihan_b' => 'required|string',
        'pilihan_c' => 'required|string',
        'pilihan_d' => 'required|string',
        'pilihan_e' => 'required|string',
        'jawaban' => 'required|string|in:pilihan_a,pilihan_b,pilihan_c,pilihan_d,pilihan_e',
        ]);
        $imageName = null;
        if ($this->gambar) {
            // Compress the image
            $image = Image::make($this->gambar->getRealPath());
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75); // 75 is the quality percentage

            // Save the compressed image
            $imageName = 'images/' . uniqid() . '.jpg';
            \Storage::disk('public')->put($imageName, (string) $image);
        }

        if($this->id_kategori == null){
            session()->flash('gagal','Silakan isi dulu Kategori Soal');
        $this->clearForm();
        $this->dispatch('closeModal');
        } else {
            ModelsSoal::create([
                'id_kategori' => $this->id_kategori,
                'soal' => $this->soal,
                'pilihan_a' => $this->pilihan_a,
                'pilihan_b' => $this->pilihan_b,
                'pilihan_c' => $this->pilihan_c,
                'pilihan_d' => $this->pilihan_d,
                'pilihan_e' => $this->pilihan_e,
                'jawaban' => $this->jawaban,
                'gambar' => $imageName
            ]);

            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }


    }
    public function clearForm(){
        $this->soal = '';
        $this->pilihan_a = '';
        $this->pilihan_b = '';
        $this->pilihan_c = '';
        $this->pilihan_d = '';
        $this->pilihan_e = '';
        $this->jawaban = '';
    }
    public function edit($id){
        $data = ModelsSoal::where('id_soal', $id)->first();
        $this->soal = $data->soal;
        $this->pilihan_a = $data->pilihan_a;
        $this->pilihan_b = $data->pilihan_b;
        $this->pilihan_c = $data->pilihan_c;
        $this->pilihan_d = $data->pilihan_d;
        $this->pilihan_e = $data->pilihan_e;
        $this->jawaban = $data->jawaban;
        $this->id_soal = $id;
        $this->gambar = $data->gambar;
    }
    public function update() {
        $this->validate([
            'gambar' => 'nullable|image|max:5024',
            'soal' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'pilihan_e' => 'required|string',
            'jawaban' => 'required|string|in:pilihan_a,pilihan_b,pilihan_c,pilihan_d,pilihan_e',
        ]);

        $data = ModelsSoal::find($this->id_soal);
        $imageName = $data->gambar; // default ke gambar lama

        if ($this->gambar) {
            // Hapus gambar lama jika ada
            if ($data->gambar && \Storage::disk('public')->exists($data->gambar)) {
                \Storage::disk('public')->delete($data->gambar);
            }

            // Compress and save the new image
            $image = Image::make($this->gambar->getRealPath());
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75); // 75 is the quality percentage

            $imageName = 'images/' . uniqid() . '.jpg';
            \Storage::disk('public')->put($imageName, (string) $image);
        }

        // Update data soal
        $data->update([
            'id_kategori' => $this->id_kategori,
            'soal' => $this->soal,
            'pilihan_a' => $this->pilihan_a,
            'pilihan_b' => $this->pilihan_b,
            'pilihan_c' => $this->pilihan_c,
            'pilihan_d' => $this->pilihan_d,
            'pilihan_e' => $this->pilihan_e,
            'jawaban' => $this->jawaban,
            'gambar' => $imageName,
        ]);

        session()->flash('sukses', 'Data berhasil diperbarui');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function c_delete($id){
        $this->id_soal = $id;
    }
    public function delete() {
        // Ambil data soal berdasarkan id
        $data = ModelsSoal::find($this->id_soal);

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
