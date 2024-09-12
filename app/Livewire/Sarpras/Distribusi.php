<?php

namespace App\Livewire\Sarpras;

use App\Models\Barang;
use Livewire\Component;
use App\Models\Distribusi as TabelDistribusi;
use App\Models\Role;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Distribusi extends Component
{
    public $id_distribusi, $id_barang, $kode_barang, $nama_barang, $volume, $satuan, $tahun_masuk, $sumber, $jenis ,$id_ruangan, $id_role;
    use WithPagination;

    public $cari = '';
    public $cari_unit = '';
    public $result = 10;
    public function render()
    {

        $ruangan = Ruangan::all();
        $role = Role::all();
        if(Auth::user()->id_role == 1 || Auth::user()->id_role == 16 || Auth::user()->id_role == 17 || Auth::user()->id_role == 3){
            $data  = TabelDistribusi::leftJoin('roles as roles_distribusi', 'roles_distribusi.id_role', '=', 'distribusi.id_role_distribusi')
            ->leftJoin('bos_realisasi', 'bos_realisasi.id_realisasi', '=', 'distribusi.id_realisasi')
            ->leftJoin('pengajuan', 'pengajuan.id_pengajuan', '=', 'bos_realisasi.id_pengajuan')
            ->leftJoin('roles as roles_pengajuan', 'roles_pengajuan.id_role', '=', 'pengajuan.id_role') // Join untuk roles dari pengajuan
            ->select(
                'distribusi.*',
                'roles_distribusi.nama_role as nama_role_distribusi', // Alias untuk roles di distribusi
                'roles_pengajuan.nama_role as nama_role_pengajuan',   // Alias untuk roles di pengajuan
                'bos_realisasi.id_realisasi',
                'pengajuan.id_pengajuan',
                'pengajuan.nama_barang',
                'pengajuan.nama_kegiatan',
                'pengajuan.tahun_arkas',
                'pengajuan.satuan',
                'pengajuan.jenis',
                'volume_realisasi'
            )
            ->orderBy('id_distribusi', 'desc')
            ->where('roles_distribusi.nama_role', 'like', '%' . $this->cari_unit . '%') // Gunakan alias roles_distribusi
            ->where('pengajuan.nama_barang', 'like', '%' . $this->cari . '%') // Pastikan nama_barang berasal dari pengajuan
            ->paginate($this->result);
        } else {
            $data  = TabelDistribusi::leftJoin('roles as roles_distribusi', 'roles_distribusi.id_role', '=', 'distribusi.id_role_distribusi')
            ->leftJoin('bos_realisasi', 'bos_realisasi.id_realisasi', '=', 'distribusi.id_realisasi')
            ->leftJoin('pengajuan', 'pengajuan.id_pengajuan', '=', 'bos_realisasi.id_pengajuan')
            ->leftJoin('roles as roles_pengajuan', 'roles_pengajuan.id_role', '=', 'pengajuan.id_role') // Join untuk roles dari pengajuan
            ->select(
                'distribusi.*',
                'roles_distribusi.nama_role as nama_role_distribusi', // Alias untuk roles di distribusi
                'roles_pengajuan.nama_role as nama_role_pengajuan',   // Alias untuk roles di pengajuan
                'bos_realisasi.id_realisasi',
                'pengajuan.id_pengajuan',
                'pengajuan.nama_barang',
                'pengajuan.nama_kegiatan',
                'pengajuan.tahun_arkas',
                'pengajuan.satuan',
                'pengajuan.jenis',
                'volume_realisasi'
            )
            ->orderBy('id_distribusi', 'desc')
            ->where('distribusi.id_role_distribusi', Auth::user()->id_role)
            ->where('roles_distribusi.nama_role', 'like', '%' . $this->cari_unit . '%') // Gunakan alias roles_distribusi
            ->where('pengajuan.nama_barang', 'like', '%' . $this->cari . '%') // Pastikan nama_barang berasal dari pengajuan
            ->paginate($this->result);

        }

        return view('livewire.sarpras.distribusi', compact('data','ruangan','role'));
    }

    public function c_delete($id){
        $data = TabelDistribusi::where('id_distribusi', $id)->first();
        $this->id_distribusi = $id;

    }
    public function delete(){
        TabelDistribusi::where('id_distribusi',$this->id_distribusi)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->dispatch('closeModal');
    }
}
