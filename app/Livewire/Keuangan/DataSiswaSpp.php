<?php

namespace App\Livewire\Keuangan;

use App\Models\Kelas;
use App\Models\Angkatan;
use App\Models\Jurusan;
use Livewire\Component;
use App\Models\DataPkl;
use App\Models\DataSiswa;
use App\Models\DataUser;
use App\Models\LogSpp;
use App\Models\MasterSpp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Str;

class DataSiswaSpp extends Component
{
    public $id_siswa, $nominal, $tahun, $nama_lengkap, $kelas, $keterangan, $bulan, $tingkat, $status;
    public $bebas = false;
    use WithPagination;
    public $cari = '';
    public $cari_kelas ='';
    public $result = 10;
    public function render()
    {
        $kls = Str::after(Auth::user()->username, 'stafkeuangan');

        if(Auth::user()->id_role == 14){
            $datakelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->where('tingkat', $kls)
        ->orderBy('kelas.tingkat','asc')->orderBy('kelas.id_jurusan','asc')->orderBy('kelas.nama_kelas','asc')->get();
            if($this->cari_kelas != ''){
            $data  = DataSiswa::leftJoin('users','users.id','=','data_siswa.id_user')
            ->leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->orderBy('nama_lengkap','asc')
            ->where(function ($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                    ->orWhere('no_hp', 'like', '%' . $this->cari . '%')
                    ->orWhere('nis', 'like', '%' . $this->cari . '%');
            })
            ->where('kelas.id_kelas', $this->cari_kelas)
            ->where('kelas.tingkat', $kls)
            ->paginate($this->result);
            } else {
                $data  = DataSiswa::leftJoin('users','users.id','=','data_siswa.id_user')
            ->leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
            ->orderBy('nama_lengkap','asc')
            ->where('kelas.tingkat', $kls)
            ->where(function ($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                    ->orWhere('no_hp', 'like', '%' . $this->cari . '%')
                    ->orWhere('nis', 'like', '%' . $this->cari . '%');
            })
            ->paginate($this->result);
            }
        } else {
            $datakelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')->where('tingkat','<','13')->orderBy('kelas.tingkat','asc')->orderBy('kelas.id_jurusan','asc')->orderBy('kelas.nama_kelas','asc')->get();
        if($this->cari_kelas != ''){
        $data  = DataSiswa::leftJoin('users','users.id','=','data_siswa.id_user')
        ->leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->orderBy('nama_lengkap','asc')
        ->where(function ($query) {
            $query->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                ->orWhere('no_hp', 'like', '%' . $this->cari . '%')
                ->orWhere('nis', 'like', '%' . $this->cari . '%');
        })
        ->where('kelas.id_kelas', $this->cari_kelas)
        ->paginate($this->result);
        } else {
            $data  = DataSiswa::leftJoin('users','users.id','=','data_siswa.id_user')
        ->leftJoin('kelas','kelas.id_kelas','=','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->orderBy('nama_lengkap','asc')
        ->where(function ($query) {
            $query->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                ->orWhere('no_hp', 'like', '%' . $this->cari . '%')
                ->orWhere('nis', 'like', '%' . $this->cari . '%');
        })
        ->paginate($this->result);
        }
        }


        return view('livewire.keuangan.data-siswa-spp', compact('data','datakelas'));
    }

    public function clearForm(){
        $this->id_siswa = '';
        $this->nominal = '';
        $this->bulan = '';
        $this->kelas = '';
        $this->keterangan = '';
    }
    public function bayar($id){
        $data = DataSiswa::leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->where('id_siswa', $id)->first();
        $spp = MasterSpp::where('kelas', $data->tingkat)->first();

        $this->id_siswa = $id;
        $this->nama_lengkap = $data->nama_lengkap;
        $this->kelas = $spp->kelas;
        $this->nominal = $spp->nominal;
    }
    public function bayarspp(){
        $this->validate([
            'kelas' => 'required',
            'nominal' => 'required',
            'bulan' => 'required',
        ]);
        $count = LogSpp::where('id_siswa', $this->id_siswa)
        ->where('bulan', $this->bulan)
        ->where('kelas', $this->kelas)
        ->count();
        $bln = DB::table('master_bulan')->where('kode', $this->bulan)->first();
        $spp = MasterSpp::where('kelas', $this->kelas)->first();
        $total = LogSpp::where('id_siswa', $this->id_siswa)
        ->where('bulan', $this->bulan)
        ->where('kelas', $this->kelas)
        ->where('status', 'cicil')
        ->sum('nominal');
        $input = $this->nominal + $total;

            if($input > $spp->nominal){
                session()->flash('gagal','Melebihi nominal SPP semestinya yaitu Rp. '.$spp->nominal);
                $this->clearForm();
                $this->dispatch('closeModal');
            } elseif($input == $spp->nominal) {
                LogSpp::create([
                    'id_siswa' => $this->id_siswa,
                    'nominal' => $this->nominal,
                    'kelas' => $this->kelas,
                    'bulan' => $this->bulan,
                    'keterangan' => $this->kelas.'/'.$bln->bulan,
                    'status' => 'lunas'
                ]);
                session()->flash('sukses','Data berhasil ditambahkan');
                $this->clearForm();
                $this->dispatch('closeModal');
            } else {
                if($this->bebas){
                    LogSpp::create([
                        'id_siswa' => $this->id_siswa,
                        'nominal' => $this->nominal,
                        'kelas' => $this->kelas,
                        'bulan' => $this->bulan,
                        'keterangan' => $this->kelas.'/'.$bln->bulan,
                        'status' => 'lunas'
                    ]);
                    session()->flash('sukses','Data berhasil ditambahkan');
                    $this->clearForm();
                    $this->dispatch('closeModal');
                } else {
                    LogSpp::create([
                        'id_siswa' => $this->id_siswa,
                        'nominal' => $this->nominal,
                        'kelas' => $this->kelas,
                        'bulan' => $this->bulan,
                        'keterangan' => $this->kelas.'/'.$bln->bulan,
                        'status' => 'cicil'
                    ]);
                    session()->flash('sukses','Data berhasil ditambahkan');
                    $this->clearForm();
                    $this->dispatch('closeModal');
                }

            }
    }
}
