<?php

namespace App\Livewire\Sitepat;

use App\Models\Ujian;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UjianMgmt extends Component
{
    public $id_kelas, $waktu, $nama_ujian, $link, $acc, $token, $kelasedit, $id_ujian;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $kelasku = [];
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        if(Auth::user()->id_role == 8) {
            $kelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')->get();
            $data = Ujian::leftJoin('kelas','kelas.id_kelas','ujian.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->leftJoin('data_siswa','data_siswa.id_kelas','=','kelas.id_kelas')
            ->where('ujian.nama_ujian', 'like','%'.$this->cari.'%')
            ->where('data_siswa.id_user', Auth::user()->id)
            ->orderBy('ujian.created_at', 'desc')
            ->paginate($this->result);
            return view('livewire.sitepat.ujian-mgmt', compact('data','kelas'));
        } else {
            $kelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')->get();
            $data = Ujian::leftJoin('kelas','kelas.id_kelas','ujian.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->where('ujian.nama_ujian', 'like','%'.$this->cari.'%')
            ->orderBy('ujian.created_at', 'desc')
            ->paginate($this->result);
            return view('livewire.sitepat.ujian-mgmt', compact('data','kelas'));
        }
    }
    public function clearForm(){
        $this->nama_ujian = '';
        $this->id_kelas = '';
        $this->waktu = '';
        $this->link = '';
        $this->acc = '';
        $this->token = '';
    }
    public function insert(){
        $this->validate([
            'nama_ujian' => 'required',
            'kelasku' => 'required',
            'waktu' => 'required',
            'link' => 'required',
            'acc' => 'required',
            'token' => 'required'
        ]);
        for($no=0; $no < count($this->kelasku); $no++){
            Ujian::create([
                'nama_ujian' => $this->nama_ujian,
                'id_kelas' => $this->id_kelas[$no],
                'waktu' => $this->waktu,
                'link' => $this->link,
                'token' => $this->token,
                'acc' => $this->acc,
            ]);
        }

        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatch('closeModal');
    }
    public function edit($id){
        $data = DB::table('ujian')
        ->leftJoin('kelas','kelas.id_kelas','ujian.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->where('id_ujian', $id)
        ->first();
        $this->id_ujian = $id;
        $this->nama_ujian = $data->nama_ujian;
        $this->id_kelas = $data->id_kelas;
        $this->waktu = $data->waktu;
        $this->link = $data->link;
        $this->acc = $data->acc;
        $this->token = $data->token;
        $this->kelasedit = $data->tingkat.' '.$data->singkatan.' '.$data->nama_kelas;
    }
    public function update(){
        $this->validate([
            'nama_ujian' => 'required',
            'id_kelas' => 'required',
            'waktu' => 'required',
            'link' => 'required',
            'acc' => 'required'
        ]);
        Ujian::where('id_ujian', $this->id_ujian)->update([
            'nama_ujian' => $this->nama_ujian,
            'id_kelas' => $this->id_kelas,
            'waktu' => $this->waktu,
            'link' => $this->link,
            'acc' => $this->acc,
            'token' => $this->token,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diubah');
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $data = Ujian::where('id_ujian',$id)->first();
        $this->id_ujian = $data->id_ujian;
    }
    public function delete(){
        Ujian::where('id_ujian', $this->id_ujian)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatch('closeModal');
    }
    public function hapusSemua(){
        Ujian::where('id_ujian','>',0)->delete();
        session()->flash('sukses', 'Semua Ujian Terhapus Semua');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function allow(){
        Ujian::where('id_ujian','>',0)->update([
            'acc' => 'y'
        ]);
    }
    public function disallow(){
        Ujian::where('id_ujian','>',0)->update([
            'acc' => 'n'
        ]);
    }
}
