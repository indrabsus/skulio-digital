<?php

namespace App\Livewire\Ppdb;

use App\Http\Controllers\Controller;
use App\Models\KelasPpdb;
use App\Models\LogPpdb;
use App\Models\LogTabungan;
use App\Models\MasterPpdb;
use App\Models\Setingan;
use App\Models\User;
use Livewire\Component;
use App\Models\SiswaPpdb as TabelSiswaPpdb;
use Livewire\WithPagination;

class SiswaPpdb extends Component
{
    public $id_siswa, $id_ppdb, $id_user,$nama_ibu,$nama_ayah,$minat_jurusan1 , $minat_jurusan2 ,$asal_sekolah,$nik_siswa,$nisn,$bayar_daftar, $id_kelas, $jenkel, $no_hp, $nis, $nama_lengkap;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {   
        $master_ppdb = MasterPpdb::all();
        $kelas_ppdb = KelasPpdb::all();
        $data  = TabelSiswaPpdb::leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_ppdb.id_kelas')
        ->orderBy('id_siswa','desc')
        ->where('nama_lengkap', 'like','%'.$this->cari.'%')
        ->paginate($this->result);
        return view('livewire.ppdb.siswa-ppdb', compact('data','kelas_ppdb'));
    }
    public function insert(){
        $this->validate([
            'id_kelas'=> 'required',
            'jenkel' => 'required',
            'no_hp'=> 'required',
            'nis'=> 'required|unique:data_siswa',
            'nama_lengkap'=> 'required',
            'nama_ayah'=> 'required',
            'nama_ibu'=> 'required',
            'asal_sekolah'=> 'required',
            'minat_jurusan1'=> 'required',
            'minat_jurusan2'=> 'required',
            'nik_siswa'=> 'required',
            'nisn'=> 'required',
        ]);

        $data2 = TabelSiswaPpdb::create([
            'nama_lengkap'=> ucwords($this->nama_lengkap),
            'jenkel'=> $this->jenkel,
            'no_hp'=> $this->no_hp,
            'nis'=> $this->nis,
            'id_kelas' => $this->id_kelas,
            'nama_ayah' => $this->nama_ayah,
            'nama_ibu' => $this->nama_ibu,
            'asal_sekolah' => $this->asal_sekolah,
            'minat_jurusan1' => $this->minat_jurusan1,
            'minat_jurusan2' => $this->minat_jurusan2,
            'nik_siswa' => $this->nik_siswa,
            'nisn' => $this->nisn,
            'bayar_daftar' => 'n',
        ]);

        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->id_kelas = '';
        $this->nama_lengkap = '';
        $this->jenkel = '';
        $this->no_hp = '';
        $this->nis = '';
        $this->id_kelas = '';
        $this->nama_ayah = '';
        $this->nama_ibu = '';
        $this->asal_sekolah = '';
        $this->nik_siswa = '';
        $this->minat_jurusan1 = '';
        $this->minat_jurusan2 = '';
        $this->nisn = '';
        $this->bayar_daftar = '';
    }
    public function edit($id){

        $data = TabelSiswaPpdb::where('id_siswa', $id)->first();
        $this->nama_lengkap = $data->nama_lengkap;
        $this->jenkel = $data->jenkel;
        $this->no_hp = $data->no_hp;
        $this->nis = $data->nis;
        $this->id_user = $id;
        $this->id_kelas = $data->id_kelas;
        $this->id_siswa = $data->id_siswa;
        $this->nama_ayah = $data->nama_ayah;
        $this->nama_ibu = $data->nama_ibu;
        $this->asal_sekolah = $data->asal_sekolah;
        $this->minat_jurusan1 = $data->minat_jurusan1;
        $this->minat_jurusan2 = $data->minat_jurusan2;
        $this->nik_siswa = $data->nik_siswa;
        $this->nisn = $data->id_siswa;
        $this->bayar_daftar = $data->bayar_daftar;
    }
    public function update(){
            $this->validate([
                'id_kelas'=> 'required',
                'jenkel' => 'required',
                'no_hp'=> 'required',
                'nis'=> 'required',
                'nama_lengkap'=> 'required',
                'nama_ayah'=> 'required',
                'nama_ibu'=> 'required',
                'asal_sekolah'=> 'required',
                'minat_jurusan1'=> 'required',
                'minat_jurusan2'=> 'required',
                'nik_siswa'=> 'required',
                'nisn'=> 'required',
                'bayar_daftar'=> 'required',
            ]);
 
        $data = TabelSiswaPpdb::where('id_siswa', $this->id_siswa)->update([
            'nama_lengkap'=> ucwords($this->nama_lengkap),
            'jenkel'=> $this->jenkel,
            'no_hp'=> $this->no_hp,
            'nis'=> $this->nis,
            'id_kelas' => $this->id_kelas,
            'nama_ibu' => $this->nama_ibu,
            'asal_sekolah' => $this->asal_sekolah,
            'minat_jurusan1' => $this->minat_jurusan1,
            'minat_jurusan2' => $this->minat_jurusan2,
            'nik_siswa' => $this->nik_siswa,
            'nisn' => $this->nisn,
            'bayar_daftar' => $this->bayar_daftar,
        ]);

        

        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function ppdb($id){

        $data = TabelSiswaPpdb::where('id_siswa', $id)->first();
        $this->nama_lengkap = $data->nama_lengkap;
        $this->id_siswa = $data->id_siswa;
        
    }
    public function insertppdb(){

        $data = MasterPpdb::where('tahun', $_GET['tahun'])->first();
        $data = LogPpdb::create([
            'id_siswa'=> $this->id_siswa,
            'id_ppdb'=> $data->daftar,
            'nominal'=> 0,
            'jenis'=>'p'

        ]);

        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');

    }



     public function daftar($id){
        $siswa = TabelSiswaPpdb::where('id_siswa', $id)->first();
        if ($siswa->bayar_daftar == 'n') {
            TabelSiswaPpdb::where('id_siswa', $id)->update([
                'bayar_daftar' => 'y'
            ]);

            $data = MasterPpdb::where('tahun', $_GET['tahun'])->first();
            $data = LogPpdb::create([
                'id_siswa'=> $this->id_siswa,
                'nominal'=> $data->daftar,
                'jenis'=>'d'
    
            ]);
        } else {
            TabelSiswaPpdb::where('id_siswa', $id)->update([
                'bayar_daftar' => 'n'
            ]);
        } 
    }
}



