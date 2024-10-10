<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use App\Models\BukuOnline as TabelBukuOnline;
use App\Models\MapelKelas;
use App\Models\SubmitTugas as ModelsSubmitTugas;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class SubmitTugas extends Component
{
    public $jawaban,
    $deskripsi,
     $id_submit, $nama_tugas, $nilai;
    use WithPagination;
    public $carikelas = '';
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $kelas = MapelKelas::leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->where('mapel_kelas.id_user', Auth::user()->id)
        ->orderBy('kelas.tingkat','asc')
        ->orderBy('kelas.id_jurusan','asc')
        ->orderBy('kelas.nama_kelas','asc')
        ->get();
        if(Auth::user()->id_role == 6){
            $data  = ModelsSubmitTugas::orderBy('id_submit','desc')
        ->leftJoin('tugas','tugas.id_tugas','=','submit_tugas.id_tugas')
        ->leftJoin('data_siswa','data_siswa.id_user','=','submit_tugas.id_user')
        ->leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->where('tugas.id_user', Auth::user()->id)
        ->where('tugas.id_kelas', 'like','%'.$this->carikelas.'%')
        ->where('nama_tugas', 'like','%'.$this->cari.'%')->paginate($this->result);
        } else {
            $data  = ModelsSubmitTugas::orderBy('id_submit','desc')
            ->leftJoin('tugas','tugas.id_tugas','=','submit_tugas.id_tugas')
            ->leftJoin('data_user','data_user.id_user','=','tugas.id_user')
            ->where('submit_tugas.id_user', Auth::user()->id)
            ->where('tugas.id_kelas', 'like','%'.$this->carikelas.'%')
            ->where('nama_tugas', 'like','%'.$this->cari.'%')->paginate($this->result);
        }
        return view('livewire.karyawan.submit-tugas', compact('data','kelas'));
    }
    public function review($id){
        $data = ModelsSubmitTugas::leftJoin('tugas','tugas.id_tugas','=','submit_tugas.id_tugas')->where('id_submit', $id)->first();
        $this->id_submit = $data->id_submit;
        $this->jawaban = $data->jawaban;
        $this->deskripsi = $data->deskripsi;
        $this->nama_tugas = $data->nama_tugas;
        $this->nilai = $data->nilai;
    }
    public function submitReview(){
        ModelsSubmitTugas::where('id_submit', $this->id_submit)->update([
            'nilai' => $this->nilai
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->id_submit = '';
        $this->jawaban = '';
        $this->deskripsi = '';
        $this->nama_tugas = '';
        $this->nilai = '';
    }
    public function c_delete($id){
        $this->id_submit = $id;
    }
    public function delete(){
        ModelsSubmitTugas::where('id_submit',$this->id_submit)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
