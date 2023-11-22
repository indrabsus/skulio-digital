<?php

namespace App\Livewire\Sarpras;

use Livewire\Component;
use App\Models\Pengajuan as TabelPengajuan;
use App\Models\Role;
use Livewire\WithPagination;

class Pengajuan extends Component
{
    public $id_pengajuan, $nama_barang, $volume, $satuan, $bulan_pengajuan, $tahun_arkas ,$id_role, $jenis, $perkiraan_harga;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {

        $role = Role::all();
        $data  = TabelPengajuan::leftJoin('roles','roles.id_role','pengajuan.id_role')->orderBy('id_pengajuan','desc')->
        where('nama_barang', 'like','%'.$this->cari.'%')
        ->paginate($this->result);
        return view('livewire.sarpras.pengajuan', compact('data','role'));
    }
    public function insert(){
        $this->validate([
            'nama_barang' => 'required',
            'volume'=> 'required',
            'satuan'=> 'required',
            'bulan_pengajuan'=> 'required',
            'jenis'=> 'required',
            'tahun_arkas'=> 'required',
            'id_role'=> 'required',
            'perkiraan_harga'=> 'required',
        ]);

        $data = TabelPengajuan::create([
            'nama_barang' => $this->nama_barang,
            'volume'=> $this->volume,
            'satuan'=> $this->satuan,
            'bulan_pengajuan'=> $this->bulan_pengajuan,
            'jenis'=> $this->jenis,
            'tahun_arkas'=> $this->tahun_arkas,
            'id_role'=> $this->id_role,
            'perkiraan_harga'=> $this->perkiraan_harga,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_barang = '';
        $this->volume = '';
        $this->satuan = '';
        $this->bulan_pengajuan = '';
        $this->jenis = '';
        $this->tahun_arkas = '';
        $this->id_role = '';
        $this->perkiraan_harga = '';
    }
    public function edit($id){
        $data = TabelPengajuan::where('id_pengajuan', $id)->first();
        $this->id_pengajuan = $data->id_pengajuan;
        $this->nama_barang = $data->nama_barang;
        $this->volume =  $data->volume;
        $this->satuan = $data->satuan;
        $this->bulan_pengajuan = $data->bulan_pengajuan;
        $this->jenis = $data->jenis;
        $this->tahun_arkas = $data->tahun_arkas;
        $this->id_role = $data->id_role;
        $this->perkiraan_harga = $data->perkiraan_harga;
    }


    public function update(){
        $this->validate([
            'nama_barang' => 'required',
            'volume'=> 'required',
            'satuan'=> 'required',
            'bulan_pengajuan'=> 'required',
            'jenis'=> 'required',
            'tahun_arkas'=> 'required',
            'id_role'=> 'required',
            'perkiraan_harga'=> 'required',
        ]);
        $data = TabelPengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'nama_barang' => $this->nama_barang,
            'volume'=> $this->volume,
            'satuan'=> $this->satuan,
            'bulan_pengajuan'=> $this->bulan_pengajuan,
            'jenis'=> $this->jenis,
            'tahun_arkas'=> $this->tahun_arkas,
            'id_role'=> $this->id_role,
            'perkiraan_harga'=> $this->perkiraan_harga,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $data = TabelPengajuan::where('id_pengajuan', $id)->first();
        $this->id_pengajuan = $id;
    }
    public function delete(){
        TabelPengajuan::where('id_pengajuan',$this->id_pengajuan)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
