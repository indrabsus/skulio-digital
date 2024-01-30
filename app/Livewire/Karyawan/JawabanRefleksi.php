<?php

namespace App\Livewire\Karyawan;

use App\Models\JwbnRefleksi;
use App\Models\Kombel;
use Livewire\Component;
use App\Models\Angkatan as TabelAngkatan;
use App\Models\Refleksi as ModelsRefleksi;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class JawabanRefleksi extends Component
{
    public $id_refleksi, $jawaban, $pertanyaan;
    use WithPagination;

    public $pertemuan = 1;
    public $result = 10;
    public function render()
    {
        $pert = Kombel::all();
        $data  = ModelsRefleksi::leftJoin('kombel','kombel.id_kombel','refleksi.id_kombel')
        ->orderBy('refleksi.id_refleksi','asc')->where('pertemuan', $this->pertemuan)->paginate($this->result);
        return view('livewire.karyawan.jawaban-refleksi', compact('data','pert'));
    }

    public function clearForm(){
        $this->jawaban = '';
    }
    public function cjawab($id){
        $data = ModelsRefleksi::where('id_refleksi', $id)->first();
        $this->id_refleksi = $id;
        $this->pertanyaan = $data->pertanyaan;
    }
    public function jawab(){
        $this->validate([
            'jawaban' => 'required',
        ]);
        $data = JwbnRefleksi::create([
            'id_refleksi' => $this->id_refleksi,
            'id_user' => Auth::user()->id,
            'jawaban' => $this->jawaban,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

}
