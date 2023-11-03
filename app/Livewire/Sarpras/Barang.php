<?php

namespace App\Livewire\Sarpras;

use Livewire\Component;
use App\Models\Barang as TabelBarang;
use App\Models\Distribusi as TabelDistribusi;
use App\Models\Role;
use App\Models\Ruangan;
use Livewire\WithPagination;

class barang extends Component
{
    public $id_barang, $kode_barang, $nama_barang, $volume, $satuan, $tahun_masuk, $sumber, $jenis ,$id_ruangan, $id_role;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $ruangan = Ruangan::all();
        $role = Role::all();
        $data  = TabelBarang::leftJoin('ruangan','ruangan.id_ruangan','barang.id_ruangan')-> leftJoin('roles','roles.id_role','barang.id_role')->where('nama_barang', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.Sarpras.barang', compact('data','ruangan','role'));
    }
    public function insert(){
        $this->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'volume'=> 'required|numeric|min:1',
            'satuan'=> 'required',
            'tahun_masuk'=> 'required',
            'sumber'=> 'required',
            'jenis'=> 'required',
            'id_ruangan' => 'required',
            'id_role'=> 'required',

        ]);

        $data = TabelBarang::create([
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'volume'=> $this->volume,
            'satuan'=> $this->satuan,
            'tahun_masuk'=> $this->tahun_masuk,
            'sumber'=> $this->sumber,
            'jenis'=> $this->jenis,
            'id_ruangan' => $this->id_ruangan,
            'id_role'=> $this->id_role,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->kode_barang = '';
        $this->nama_barang = '';
        $this->volume = '';
        $this->satuan = '';
        $this->tahun_masuk = '';
        $this->sumber = '';
        $this->jenis = '';
        $this->id_ruangan = '';
        $this->id_role = '';
    }
    public function edit($id){
        $data = TabelBarang::where('id_barang', $id)->first();
        $this->id_barang = $data->id_barang;
        $this->kode_barang = $data->kode_barang;
        $this->nama_barang = $data->nama_barang;
        $this->volume =  $data->volume;
        $this->satuan = $data->satuan;
        $this->tahun_masuk = $data->tahun_masuk;
        $this->sumber = $data->sumber;
        $this->jenis = $data->jenis;
        $this->id_ruangan = $data->id_ruangan;
        $this->id_role = $data->id_role;
    }


    public function Distribusi($id){
        $data = TabelBarang::where('id_barang', $id)->first();
        $this->id_barang = $data->id_barang;
        $this->kode_barang = $data->kode_barang;
        $this->nama_barang = $data->nama_barang;
        $this->volume =  $data->volume;
        $this->satuan = $data->satuan;
        $this->tahun_masuk = $data->tahun_masuk;
        $this->sumber = $data->sumber;
        $this->jenis = $data->jenis;
        $this->id_ruangan = $data->id_ruangan;
        $this->id_role = $data->id_role;
    }


    public function Prosesdistribusi(){
        $this->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'volume'=> 'required',
            'satuan'=> 'required',
            'tahun_masuk'=> 'required',
            'sumber'=> 'required',
            'jenis'=> 'required',
            'id_ruangan' => 'required',
            'id_role'=> 'required',
        ]);
        $tabelbarang = TabelBarang::where('id_barang', $this->id_barang)->first();

        if((int)$this->volume > (int)$tabelbarang->volume){
            session()->flash('gagal','Volume tidak sesuai');
        $this->clearForm();
        $this->dispatch('closeModal');
        } else {
            $data = TabelBarang::where('id_barang', $this->id_barang)->update([
                'kode_barang' => $this->kode_barang,
                'nama_barang' => $this->nama_barang,
                'volume'=> (int)$tabelbarang->volume - (int)$this->volume,
                'satuan'=> $this->satuan,
                'tahun_masuk'=> $this->tahun_masuk,
                'sumber'=> $this->sumber,
                'jenis'=> $this->jenis,
                'id_ruangan' => $this->id_ruangan,
                'id_role'=> $this->id_role,
            ]);
    
            $data = TabelDistribusi ::create([
                'id_barang'=> $this->id_barang,
                'kode_barang' => $this->kode_barang,
                'nama_barang' => $this->nama_barang,
                'volume'=> $this->volume,
                'satuan'=> $this->satuan,
                'tahun_masuk'=> $this->tahun_masuk,
                'sumber'=> $this->sumber,
                'jenis'=> $this->jenis,
                'id_ruangan' => $this->id_ruangan,
                'id_role'=> $this->id_role,
            ]);
            session()->flash('sukses','Data berhasil distribusikan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
        
    }


    public function update(){
        $this->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'volume'=> 'required',
            'satuan'=> 'required',
            'tahun_masuk'=> 'required',
            'sumber'=> 'required',
            'jenis'=> 'required',
            'id_ruangan' => 'required',
            'id_role'=> 'required',
        ]);
        $data = TabelBarang::where('id_barang', $this->id_barang)->update([
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'volume'=> $this->volume,
            'satuan'=> $this->satuan,
            'tahun_masuk'=> $this->tahun_masuk,
            'sumber'=> $this->sumber,
            'jenis'=> $this->jenis,
            'id_ruangan' => $this->id_ruangan,
            'id_role'=> $this->id_role,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $data = TabelBarang::where('id_barang', $id)->first();
        $this->id_barang = $id;

    }
    public function delete(){
        TabelBarang::where('id_barang',$this->id_barang)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
