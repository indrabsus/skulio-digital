<?php

namespace App\Livewire\Sarpras;

use App\Models\Barang;
use Livewire\Component;
use App\Models\Distribusi as TabelDistribusi;
use App\Models\Role;
use App\Models\Ruangan;
use Livewire\WithPagination;

class Distribusi extends Component
{
    public $id_distribusi, $id_barang, $kode_barang, $nama_barang, $volume, $satuan, $tahun_masuk, $sumber, $jenis ,$id_ruangan, $id_role;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {

        $ruangan = Ruangan::all();
        $role = Role::all();
        $data  = TabelDistribusi::leftJoin('ruangan','ruangan.id_ruangan','distribusi.id_ruangan')
        ->leftJoin('roles','roles.id_role','distribusi.id_role')
        ->leftJoin('barang','barang.id_barang','distribusi.id_barang')
        ->select('distribusi.id_barang','nama_barang','distribusi.volume','sumber',
        'tahun_masuk','nama_ruangan','nama_role','id_distribusi')
        ->orderBy('id_distribusi','desc')->where('nama_barang', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.sarpras.distribusi', compact('data','ruangan','role'));
    }
    public function insert(){
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

        $data = TabelDistribusi::create([
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
        $data = TabelDistribusi::where('id_distribusi', $id)->first();
        $this->id_distribusi = $data->id_distribusi;
        $this->kode_barang = $data->kode_barang;
        $this->nama_barang = $data->nama_barang;
        $this->volume =  $data->volume;
        $this->satuan = $data->satuan;
        $this->tahun_masuk = $data->tahun_masuk;
        $this->sumber = $data->sumber;
        $this->jenis = $data->jenis;
        $this->id_ruangan = $data->id_ruangan;
        $this->id_role = $data->id_role;
        $this->id_barang = $data->id_barang;
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
        $data = TabelDistribusi::where('id_distribusi', $this->id_distribusi)->update([
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
        $data = TabelDistribusi::where('id_distribusi', $id)->first();
        $this->id_distribusi = $id;

    }
    public function delete(){
        $data = TabelDistribusi::where('id_distribusi', $this->id_distribusi)->first();
        $data2 = Barang::where('id_barang', $data->id_barang)->first();
        $data = Barang ::where('id_barang', $data->id_barang)->update([
            'volume' =>   $data2->volume + $data->volume  ,
        ]);

        TabelDistribusi::where('id_distribusi',$this->id_distribusi)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
