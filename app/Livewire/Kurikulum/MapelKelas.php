<?php

namespace App\Livewire\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Livewire\Component;
use App\Models\MapelKelas as TabelMapelKelas;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class MapelKelas extends Component
{
    public $id_mapelkelas ,$id_mapel, $id_kelas, $id_user, $tahun, $aktif, $hari=[], $hari2 = [] ;
    use WithPagination;
    public $cari_kelas ='';
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $ver = Kelas::where('id_user', Auth::user()->id)->first();
        $fungsi = new Controller;
        $guru = User::leftJoin('data_user','data_user.id_user','users.id')->where('id_role',6)->get();
        $kelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->where('tingkat','<','13')
        ->orderBy('kelas.tingkat','asc')
        ->orderBy('kelas.id_jurusan','asc')
        ->orderBy('kelas.nama_kelas','asc')
        ->get();
        $mapel = MataPelajaran::all();
        $role = Role::leftJoin('users','users.id_role','roles.id_role')->where('id', Auth::user()->id)->first();
        if($role->nama_role == 'guru'){
            $data  = TabelMapelKelas::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('data_user','data_user.id_user','=','mapel_kelas.id_user')
        ->orderBy('hari','asc')
        ->where('nama_pelajaran', 'like','%'.$this->cari.'%')
        ->where('mapel_kelas.id_user', Auth::user()->id)
        ->where('kelas.id_kelas', 'like','%'.$this->cari_kelas.'%')
        ->paginate($this->result);
        } elseif($role->nama_role == 'verifikator'){
            $data  = TabelMapelKelas::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
            ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->leftJoin('data_user','data_user.id_user','=','mapel_kelas.id_user')
            ->orderBy('hari','asc')
            ->where('nama_pelajaran', 'like','%'.$this->cari.'%')
            ->where('mapel_kelas.id_kelas', $ver->id_kelas)
            ->where('kelas.id_kelas', 'like','%'.$this->cari_kelas.'%')
            ->paginate($this->result);
        } else {
            $data  = TabelMapelKelas::leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
            ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->leftJoin('data_user','data_user.id_user','=','mapel_kelas.id_user')
            ->orderBy('hari','asc')
            ->where('kelas.id_kelas', 'like','%'.$this->cari_kelas.'%')
            ->where('nama_pelajaran', 'like','%'.$this->cari.'%')->paginate($this->result);
        }

        return view('livewire.kurikulum.mapel-kelas', compact('data','mapel','kelas','guru','fungsi'));
    }
    public function insert()
{
    $ver = Kelas::where('id_user', Auth::user()->id)->first();

    if (Auth::user()->id_role == 6) {
        $this->validate([
            'id_mapel' => 'required',
            'id_kelas' => 'required',
            'tahun' => 'required',
            'hari.*' => 'required|between:1,7'
        ]);

        $count = TabelMapelKelas::where('id_mapel', $this->id_mapel)
            ->where('id_kelas', $this->id_kelas)
            ->where('tahun', $this->tahun)
            ->count();

        $selectedHari = array_keys(array_filter($this->hari));
        $hariString = implode(',', $selectedHari); // Convert array to comma-separated string

        if ($count > 0) {
            session()->flash('gagal', 'Data Ganda');
            $this->clearForm();
            $this->dispatch('closeModal');
        } else {
            $data = TabelMapelKelas::create([
                'id_mapel' => $this->id_mapel,
                'id_kelas' => $this->id_kelas,
                'id_user' => Auth::user()->id,
                'tahun' => $this->tahun,
                'aktif' => 'y',
                'hari' => $hariString // Save as a comma-separated string
            ]);
            session()->flash('sukses', 'Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
    } elseif (Auth::user()->id_role == 5) {
        $this->validate([
            'id_mapel' => 'required',
            'id_user' => 'required',
            'tahun' => 'required',
            'hari.*' => 'required|between:1,7'
        ]);

        $selectedHari = array_keys(array_filter($this->hari));
        $hariString = implode(',', $selectedHari); // Convert array to comma-separated string

        $count = TabelMapelKelas::where('id_mapel', $this->id_mapel)
            ->where('id_kelas', $ver->id_kelas)
            ->where('tahun', $this->tahun)
            ->count();

        if ($count > 0) {
            session()->flash('gagal', 'Data Ganda');
            $this->clearForm();
            $this->dispatch('closeModal');
        } else {
            $data = TabelMapelKelas::create([
                'id_mapel' => $this->id_mapel,
                'id_kelas' => $ver->id_kelas,
                'id_user' => $this->id_user,
                'tahun' => $this->tahun,
                'aktif' => 'y',
                'hari' => $hariString // Save as a comma-separated string
            ]);
            session()->flash('sukses', 'Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
    } else {
        $this->validate([
            'id_mapel' => 'required',
            'id_kelas' => 'required',
            'id_user' => 'required',
            'tahun' => 'required',
            'hari.*' => 'required|between:1,7'
        ]);

        $count = TabelMapelKelas::where('id_mapel', $this->id_mapel)
            ->where('id_kelas', $this->id_kelas)
            ->where('id_user', $this->id_user)
            ->where('tahun', $this->tahun)
            ->count();

        if ($count > 0) {
            session()->flash('gagal', 'Data Ganda');
            $this->clearForm();
            $this->dispatch('closeModal');
        } else {
            $selectedHari = array_keys(array_filter($this->hari));
            $hariString = implode(', ', $selectedHari); // Convert array to comma-separated string

            $data = TabelMapelKelas::create([
                'id_mapel' => $this->id_mapel,
                'id_kelas' => $this->id_kelas,
                'id_user' => $this->id_user,
                'tahun' => $this->tahun,
                'aktif' => 'y',
                'hari' => $hariString // Save as a comma-separated string
            ]);
            session()->flash('sukses', 'Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
        }
    }
}


    public function clearForm(){
        $this->id_kelas = '';
        $this->id_mapel = '';
        $this->id_user = '';
        $this->tahun = '';
        $this->aktif = '';
        $this->hari = [];
    }
    public function edit($id){
        $data = TabelMapelKelas::where('id_mapelkelas', $id)->first();
        $this->id_mapel = $data->id_mapel;
        $this->id_kelas = $data->id_kelas;
        $this->id_user = $data->id_user;
        $this->id_mapelkelas = $id;
        $this->tahun =  $data -> tahun;
        $this->aktif =  $data -> aktif;
    }
    public function update(){
        $this->validate([
            'id_mapel' => 'required',
            'id_kelas' => 'required',
            'id_user' => 'required',
            'tahun' => 'required',
            'hari.*' => 'required|between:1,7'
        ]);
        $selectedHari = array_keys(array_filter($this->hari));
        $hariString = implode(',', $selectedHari);
        // Ambil data lama berdasarkan id_mapelkelas
        $oldData = TabelMapelKelas::where('id_mapelkelas', $this->id_mapelkelas)->first();

        // Cek apakah id_user berubah
        if ($oldData && $oldData->id_user != $this->id_user) {
            // Lakukan pengecekan data ganda jika id_user berubah
            $count = TabelMapelKelas::where('id_mapel', $this->id_mapel)
                ->where('id_kelas', $this->id_kelas)
                ->where('id_user', $this->id_user)
                ->where('tahun', $this->tahun)
                ->count();

            if($count > 0){
                session()->flash('gagal', 'Data Ganda');
                $this->clearForm();
                $this->dispatch('closeModal');
                return;
            }
        }

        // Lanjutkan update jika tidak ada data ganda
        $data = TabelMapelKelas::where('id_mapelkelas', $this->id_mapelkelas)->update([
            'id_mapel' => $this->id_mapel,
            'id_kelas' => $this->id_kelas,
            'id_user' => $this->id_user,
            'tahun' => $this->tahun,
            'aktif' => 'y',
            'hari' => $hariString
        ]);

        session()->flash('sukses', 'Data berhasil diupdate');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function c_delete($id){
        $this->id_mapelkelas = $id;
    }
    public function delete(){
        TabelMapelKelas::where('id_mapelkelas',$this->id_mapelkelas)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
