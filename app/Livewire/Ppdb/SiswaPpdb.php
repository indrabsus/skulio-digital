<?php

namespace App\Livewire\Ppdb;

use App\Http\Controllers\Controller;
use App\Models\JurusanPpdb;
use App\Models\KelasPpdb;
use App\Models\LogPpdb;
use App\Models\LogTabungan;
use App\Models\MasterPpdb;
use App\Models\Setingan;
use App\Models\SiswaBaru;
use App\Models\User;
use Livewire\Component;
use App\Models\SiswaPpdb as TabelSiswaPpdb;
use Livewire\WithPagination;

class SiswaPpdb extends Component
{
    public $jenis, $id_siswa, $id_ppdb, $id_user,$nama_ibu,$nama_ayah,$minat_jurusan1 , $minat_jurusan2 ,$asal_sekolah,$nisn,$bayar_daftar, $jenkel, $no_hp, $nama_lengkap, $nik_siswa, $nom, $nom2, $kelas;
    use WithPagination;
    public $filter = 'all';

    public $cari = '';
    public $result = 10;
    public function render()
    {
        if($this->filter == 'all'){
            $data  = TabelSiswaPpdb::orderBy('id_siswa','desc')
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')
            ->paginate($this->result);
        } else{
            $data  = TabelSiswaPpdb::orderBy('id_siswa','desc')
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')
            ->where('bayar_daftar', $this->filter)
            ->paginate($this->result);
        }
        $jurusan = JurusanPpdb::all();
        $master_ppdb = MasterPpdb::all();
        $kelas_ppdb = KelasPpdb::all();

        return view('livewire.ppdb.siswa-ppdb', compact('data','kelas_ppdb','jurusan'));
    }
    public function insert(){
        $this->validate([
            'jenkel' => 'required',
            'no_hp'=> 'required',
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
    public function c_delete($id){
        $this->id_siswa = $id;
    }
    public function delete(){
        TabelSiswaPpdb::where('id_siswa',$this->id_siswa)->delete();
        LogPpdb::where('id_siswa',$this->id_siswa)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_lengkap = '';
        $this->jenkel = '';
        $this->no_hp = '';
        $this->id_kelas = '';
        $this->nama_ayah = '';
        $this->nama_ibu = '';
        $this->asal_sekolah = '';
        $this->nik_siswa = '';
        $this->minat_jurusan1 = '';
        $this->minat_jurusan2 = '';
        $this->nisn = '';
        $this->bayar_daftar = '';
        $this->nom2 = '';
    }
    public function edit($id){

        $data = TabelSiswaPpdb::where('id_siswa', $id)->first();
        $this->nama_lengkap = $data->nama_lengkap;
        $this->jenkel = $data->jenkel;
        $this->no_hp = $data->no_hp;
        $this->id_user = $id;
        $this->id_siswa = $data->id_siswa;
        $this->nama_ayah = $data->nama_ayah;
        $this->nama_ibu = $data->nama_ibu;
        $this->asal_sekolah = $data->asal_sekolah;
        $this->minat_jurusan1 = $data->minat_jurusan1;
        $this->minat_jurusan2 = $data->minat_jurusan2;
        $this->nik_siswa = $data->nik_siswa;
        $this->nisn = $data->nisn;
        $this->bayar_daftar = $data->bayar_daftar;
    }
    public function update(){
            $this->validate([
                'jenkel' => 'required',
                'no_hp'=> 'required',
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

        $nom = LogPpdb::where('id_siswa', $id)->where('jenis', 'p')->sum('nominal');
        $this->nom = $nom;
        $this->id_siswa = $id;

    }
    public function insertppdb(){
        $cek = LogPpdb::where('no_invoice', 'P'.date('dmYh').$this->id_siswa)
        ->count();
        $max = MasterPpdb::where('tahun', date('Y'))->first();
        $inputnow = $this->nom + $this->nom2;
        if($inputnow > $max->ppdb){
            session()->flash('gagal','Melebihi jumlah nominal!');
            $this->clearForm();
            $this->dispatch('closeModal');
        } else {
            if($cek < 1) {
                $data = LogPpdb::create([
                    'id_siswa'=> $this->id_siswa,
                    'nominal'=> $this->nom2,
                    'no_invoice' => 'P-'.strtoupper($this->jenis).date('dmYh').'-'.substr($this->id_siswa, 0,3),
                    'jenis'=>'p'

                ]);

                session()->flash('sukses','Berhasil membayar!');
                $this->clearForm();
                $this->dispatch('closeModal');
            } else {
                session()->flash('gagal','Tunggu beberapa saat!');
                $this->clearForm();
                $this->dispatch('closeModal');
            }
        }
    }

    public function kdaftar($id){
        $this->id_siswa = $id;
    }

     public function daftar(){
        $siswa = TabelSiswaPpdb::where('id_siswa', $this->id_siswa)->first();
        $cek = LogPpdb::where('no_invoice', 'D'.date('dmYh').$siswa->id_siswa)->count();
        if($cek < 1){
            if ($siswa->bayar_daftar == 'n') {
                $data = MasterPpdb::where('tahun', date('Y'))->first();
                if($data) {
                    $data = LogPpdb::create([
                        'id_siswa'=> $siswa->id_siswa,
                        'nominal'=> $data->daftar,
                        'no_invoice' =>'D-'.strtoupper($this->jenis).'-'.date('dmYh').'-'.substr($siswa->id_siswa, 0,3),
                        'jenis'=>'d'
                    ]);
                    TabelSiswaPpdb::where('id_siswa', $this->id_siswa)->update([
                        'bayar_daftar' => 'y'
                    ]);
                    session()->flash('sukses','Berhasil daftar!');
                    $this->clearForm();
                     $this->dispatch('closeModal');
                }
            }
        } else {
            session()->flash('gagal','Tunggu beberapa saat!');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
    }
    public function ckelas($id){
        $data = TabelSiswaPpdb::where('id_siswa',$id)->first();
        $this->minat_jurusan1 = $data->minat_jurusan1;
        $this->minat_jurusan2 = $data->minat_jurusan2;
        $this->id_siswa = $id;
    }
    public function insertkelas(){
        $cek = SiswaBaru::where('id_siswa', $this->id_siswa)->count();
        $kls = KelasPpdb::where('id_kelas', $this->kelas)->first();
        $htng = SiswaBaru::where('id_kelas', $this->kelas)->count();
        if($htng < $kls->max) {
            if($cek  < 1){
                SiswaBaru::create([
                    'id_siswa' => $this->id_siswa,
                    'id_kelas' => $this->kelas
                ]);
                session()->flash('sukses','Berhasil memilih kelas!');
                $this->clearForm();
                $this->dispatch('closeModal');
            } else {
                SiswaBaru::where('id_siswa', $this->id_siswa)->update([
                    'id_kelas' => $this->kelas
                ]);
                session()->flash('sukses','Sudah pindah kelas!');
                $this->clearForm();
                $this->dispatch('closeModal');
            }
        } else {
            session()->flash('gagal','Kelas sudah penuh!');
                $this->clearForm();
                $this->dispatch('closeModal');
        }

    }
    public function c_hkelas($id){
        $this->id_siswa = $id;
    }
    public function hapusKelas(){
        SiswaBaru::where('id_siswa', $this->id_siswa)->delete();
        session()->flash('sukses','Berhasil hapus kelas!');
                $this->clearForm();
                $this->dispatch('closeModal');
    }

    public function c_undur($id){
        $this->id_siswa = $id;
    }
    public function mengundurkandiri(){
        LogPpdb::where('id_siswa', $this->id_siswa)->where('jenis', 'p')->update([
            'jenis' => 'l'
        ]);

        TabelSiswaPpdb::where('id_siswa', $this->id_siswa)->update([
            'bayar_daftar' => 'l'
        ]);

        session()->flash('sukses','Berhasil Mengundurkan Diri!');
                $this->clearForm();
                $this->dispatch('closeModal');
    }

}



