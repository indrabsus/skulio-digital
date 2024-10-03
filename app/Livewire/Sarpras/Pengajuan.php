<?php

namespace App\Livewire\Sarpras;

use App\Models\BosRealisasi;
use Livewire\Component;
use App\Models\Pengajuan as TabelPengajuan;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Pengajuan extends Component
{
    public $id_pengajuan, $nama_barang, $volume,$volume_realisasi, $satuan, $bulan_pengajuan, $bulan_pengajuan_realisasi, $tahun_arkas ,$id_role, $jenis, $perkiraan_harga, $perkiraan_harga_realisasi, $nama_kegiatan, $link;
    use WithPagination;

    public $cari = '';
    public $centang = [];
    public $cari_unit = '';
    public $result = 10;
    public function render()
    {

        $role = Role::all();
        if(Auth::user()->id_role == 1 || Auth::user()->id_role == 16){
            $nonjasa = DB::table('pengajuan')->leftJoin('roles','roles.id_role','pengajuan.id_role')
            ->select(DB::raw('SUM(volume * perkiraan_harga) as total'))
            ->where('nama_role', 'like','%'.$this->cari_unit.'%')
            ->where('jenis','!=', 'jasa')
            ->value('total') * 1.35;
            $jasa = DB::table('pengajuan')->leftJoin('roles','roles.id_role','pengajuan.id_role')
            ->select(DB::raw('SUM(volume * perkiraan_harga) as total'))
            ->where('nama_role', 'like','%'.$this->cari_unit.'%')
            ->where('jenis', 'jasa')
            ->value('total');
            $total = $nonjasa + $jasa;

        } else {
            $nonjasa = DB::table('pengajuan')
            ->select(DB::raw('SUM(volume * perkiraan_harga) as total'))
            ->where('id_role', Auth::user()->id_role)
            ->where('jenis','!=', 'jasa')
            ->value('total') * 1.35;
            $jasa = DB::table('pengajuan')
            ->select(DB::raw('SUM(volume * perkiraan_harga) as total'))
            ->where('id_role', Auth::user()->id_role)
            ->where('jenis', 'jasa')
            ->value('total');
            $total = $nonjasa + $jasa;
        }

        if(Auth::user()->id_role == 1 || Auth::user()->id_role == 16 || Auth::user()->id_role == 17){
        $data  = TabelPengajuan::leftJoin('roles','roles.id_role','pengajuan.id_role')->orderBy('id_pengajuan','desc')
        ->where('nama_role', 'like','%'.$this->cari_unit.'%')
        ->where(function ($query) {
            $query->where('nama_barang', 'like', '%' . $this->cari . '%')
                ->orWhere('nama_kegiatan', 'like', '%' . $this->cari . '%')
                ->orWhere('bulan_pengajuan', 'like', '%' . $this->cari . '%');
        })
        ->paginate($this->result);
        } else {
            $data  = TabelPengajuan::leftJoin('roles','roles.id_role','pengajuan.id_role')->orderBy('id_pengajuan','desc')
            ->where('pengajuan.id_role', Auth::user()->id_role)
            ->where('nama_barang', 'like','%'.$this->cari.'%')
            ->where('nama_role', 'like','%'.$this->cari_unit.'%')
            ->paginate($this->result);
        }
        return view('livewire.sarpras.pengajuan', compact('data','role','total'));
    }
    public function insert(){

        if(Auth::user()->id_role == 1 || Auth::user()->id_role == 16){
            $this->validate([
                'nama_barang' => 'required',
                'nama_kegiatan'=> 'required',
                'volume'=> 'required',
                'satuan'=> 'required',
                'bulan_pengajuan'=> 'required',
                'jenis'=> 'required',
                'id_role'=> 'required',
                'perkiraan_harga'=> 'required',
            ]);
            $data = TabelPengajuan::create([
                'nama_barang' => $this->nama_barang,
                'nama_kegiatan'=> $this->nama_kegiatan,
                'volume'=> $this->volume,
                'satuan'=> $this->satuan,
                'bulan_pengajuan'=> $this->bulan_pengajuan,
                'jenis'=> $this->jenis,
                'tahun_arkas'=> date('Y') + 1,
                'id_role'=> $this->id_role,
                'perkiraan_harga'=> $this->perkiraan_harga,
                'link'=> $this->link
            ]) ;
        } else {
            $this->validate([
                'nama_barang' => 'required',
                'nama_kegiatan'=> 'required',
                'volume'=> 'required',
                'satuan'=> 'required',
                'bulan_pengajuan'=> 'required',
                'jenis'=> 'required',
                'perkiraan_harga'=> 'required',
            ]);
            $data = TabelPengajuan::create([
                'nama_barang' => $this->nama_barang,
                'nama_kegiatan'=> $this->nama_kegiatan,
                'volume'=> $this->volume,
                'satuan'=> $this->satuan,
                'bulan_pengajuan'=> $this->bulan_pengajuan,
                'jenis'=> $this->jenis,
                'tahun_arkas'=> date('Y') + 1,
                'id_role'=> Auth::user()->id_role,
                'perkiraan_harga'=> $this->perkiraan_harga,
                'link'=> $this->link
            ]) ;
        }

        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_barang = '';
        $this->nama_kegiatan = '';
        $this->volume = '';
        $this->satuan = '';
        $this->bulan_pengajuan = '';
        $this->jenis = '';
        $this->tahun_arkas = '';
        $this->id_role = '';
        $this->perkiraan_harga = '';
        $this->centang = [];
        $this->link = '';
    }
    public function edit($id){
        $data = TabelPengajuan::where('id_pengajuan', $id)->first();
        $this->id_pengajuan = $data->id_pengajuan;
        $this->nama_barang = $data->nama_barang;
        $this->nama_kegiatan = $data->nama_kegiatan;
        $this->volume =  $data->volume;
        $this->satuan = $data->satuan;
        $this->bulan_pengajuan = $data->bulan_pengajuan;
        $this->jenis = $data->jenis;
        $this->tahun_arkas = $data->tahun_arkas;
        $this->id_role = $data->id_role;
        $this->perkiraan_harga = $data->perkiraan_harga;
        $this->link = $data->link;
    }
    public function konf($id){
        $data = TabelPengajuan::where('id_pengajuan', $id)->first();
        $this->id_pengajuan = $id;
        $this->nama_barang = $data->nama_barang;
        $this->nama_kegiatan = $data->nama_kegiatan;
        $this->volume =  $data->volume;
        $this->satuan = $data->satuan;
        $this->bulan_pengajuan = $data->bulan_pengajuan;
        $this->jenis = $data->jenis;
        $this->tahun_arkas = $data->tahun_arkas;
        $this->id_role = $data->id_role;
        $this->perkiraan_harga = $data->perkiraan_harga;
        $this->volume_realisasi =  $data->volume;
        $this->bulan_pengajuan_realisasi = $data->bulan_pengajuan;
        $this->perkiraan_harga_realisasi = $data->perkiraan_harga;
        $this->link = $data->link;

    }
    public function realisasi(){
        $this->validate([
            'volume_realisasi'=> 'required',
            'bulan_pengajuan_realisasi'=> 'required',
            'perkiraan_harga_realisasi'=> 'required'
        ]);
        $data = BosRealisasi::create([
            'id_pengajuan'=> $this->id_pengajuan,
            'volume_realisasi'=> $this->volume_realisasi,
            'bulan_pengajuan_realisasi'=> $this->bulan_pengajuan_realisasi,
            'perkiraan_harga_realisasi'=> $this->perkiraan_harga_realisasi,
            'status' => 1
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function tolak(){
        $this->validate([
            'volume_realisasi'=> 'required',
            'bulan_pengajuan_realisasi'=> 'required',
            'perkiraan_harga_realisasi'=> 'required'
        ]);
        $data = BosRealisasi::create([
            'id_pengajuan'=> $this->id_pengajuan,
            'volume_realisasi'=> 0,
            'bulan_pengajuan_realisasi'=> '-',
            'perkiraan_harga_realisasi'=> 0,
            'status' => 3
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }


    public function update(){
        $this->validate([
            'nama_barang' => 'required',
            'nama_kegiatan'=> 'required',
            'volume'=> 'required',
            'satuan'=> 'required',
            'bulan_pengajuan'=> 'required',
            'jenis'=> 'required',
            'tahun_arkas'=> 'required',
            'perkiraan_harga'=> 'required',
        ]);
        $data = TabelPengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'nama_barang' => $this->nama_barang,
            'nama_kegiatan'=> $this->nama_kegiatan,
            'volume'=> $this->volume,
            'satuan'=> $this->satuan,
            'bulan_pengajuan'=> $this->bulan_pengajuan,
            'jenis'=> $this->jenis,
            'tahun_arkas'=> $this->tahun_arkas,
            'perkiraan_harga'=> $this->perkiraan_harga,
            'link'=> $this->link
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
    public function konfSelect()
{


    // Loop melalui checkbox yang dicentang
    foreach ($this->centang as $item) {
        // Cek apakah nilai mengandung pemisah '|'
        if (strpos($item, '|') !== false) {
            // Pisahkan nilai yang digabungkan menggunakan '|' sebagai pemisah
            list($id_pengajuan, $volume, $perkiraan_harga, $bulan) = explode('|', $item);

            // Cek apakah data ganda ada di tabel BosRealisasi
            $existingRecord = BosRealisasi::where('id_pengajuan', $id_pengajuan)
                ->first();

            // Jika sudah ada, beri pesan error
            if ($existingRecord) {
                session()->flash('error', 'Data ganda ditemukan untuk pengajuan: ' . $id_pengajuan);
                continue; // Lewati proses insert untuk data yang sudah ada
            }

            // Jika tidak ada data ganda, lakukan insert
            BosRealisasi::create([
                'id_pengajuan' => $id_pengajuan,
                'volume_realisasi' => $volume,
                'bulan_pengajuan_realisasi' => $bulan,
                'perkiraan_harga_realisasi' => $perkiraan_harga,
                'status' => 1
            ]);
        } else {
            session()->flash('error', 'Data tidak valid untuk item: ' . $item);
        }
    }

    // Flash message untuk notifikasi sukses jika tidak ada data ganda
    session()->flash('sukses', 'Data berhasil ditambahkan');

    // Kosongkan form setelah sukses
    $this->clearForm();

    // Tutup modal jika ada
    $this->dispatch('closeModal');
}
    public function tolakSelect()
{
    // Loop melalui checkbox yang dicentang
    foreach ($this->centang as $item) {
        // Cek apakah nilai mengandung pemisah '|'
        if (strpos($item, '|') !== false) {
            // Pisahkan nilai yang digabungkan menggunakan '|' sebagai pemisah
            list($id_pengajuan, $volume, $perkiraan_harga, $bulan) = explode('|', $item);

            // Cek apakah data ganda ada di tabel BosRealisasi
            $existingRecord = BosRealisasi::where('id_pengajuan', $id_pengajuan)
                ->first();

            // Jika sudah ada, beri pesan error
            if ($existingRecord) {
                session()->flash('error', 'Data ganda ditemukan untuk pengajuan: ' . $id_pengajuan);
                continue; // Lewati proses insert untuk data yang sudah ada
            }

            // Jika tidak ada data ganda, lakukan insert
            BosRealisasi::create([
                'id_pengajuan' => $id_pengajuan,
                'volume_realisasi' => 0,
                'bulan_pengajuan_realisasi' => '-',
                'perkiraan_harga_realisasi' => 0,
                'status' => 3
            ]);
        } else {
            session()->flash('error', 'Data tidak valid untuk item: ' . $item);
        }
    }

    // Flash message untuk notifikasi sukses jika tidak ada data ganda
    session()->flash('sukses', 'Data berhasil ditambahkan');

    // Kosongkan form setelah sukses
    $this->clearForm();

    // Tutup modal jika ada
    $this->dispatch('closeModal');
}

}
