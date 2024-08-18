<?php

namespace App\Livewire\Keuangan;

use App\Models\DataSiswa;
use App\Models\LogSpp as ModelsLogSpp;
use App\Models\Token;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class LogSpp extends Component
{
    public  $nominal, $jenis , $no_invoice, $log, $id_logspp, $created_at, $id_siswa, $bulan, $nama_lengkap, $kelas;
    use WithPagination;
    public $bln ='';
    public $thn='';
    public $cari = '';
    public $result = 10;

    public function render()
    {$kls = Str::after(Auth::user()->username, 'stafkeuangan');
        if(Auth::user()->id_role == 14){
            $data  = ModelsLogSpp::leftJoin('data_siswa','data_siswa.id_siswa','log_spp.id_siswa')
            ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->select('log_spp.*','data_siswa.nama_lengkap','jurusan.singkatan','kelas.tingkat','kelas.nama_kelas')
            ->orderBy('log_spp.created_at','desc')
            ->where('kelas.tingkat', $kls)
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
        } else {
            $data  = ModelsLogSpp::leftJoin('data_siswa','data_siswa.id_siswa','log_spp.id_siswa')
            ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->select('log_spp.*','data_siswa.nama_lengkap','jurusan.singkatan','kelas.tingkat','kelas.nama_kelas')
            ->orderBy('log_spp.created_at','desc')
            ->where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
        }

            return view('livewire.keuangan.log-spp', compact('data'));
    }
    public function edit($id){
        $data = ModelsLogSpp::where('id_logspp', $id)->first();
        $this->id_logspp = $id;
        $this->created_at = $data->created_at;
        $this->id_siswa = $data->id_siswa;
        $this->bulan = $data->bulan;
    }
    public function update(){
        $this->validate([
            'created_at' => 'required',
        ]);
        $data = ModelsLogSpp::where('id_logspp', $this->id_logspp)->update([
            'created_at' => $this->created_at,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        // $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function k_delete($id){
        $data = ModelsLogSpp::where('id_logspp', $id)->first();
        $this->id_logspp = $id;
        $this->created_at = $data->created_at;
        $this->id_siswa = $data->id_siswa;
        $this->bulan = $data->bulan;
        $this->kelas = $data->kelas;
    }
    public function delete(){
        $bln = DB::table('master_bulan')->where('kode', $this->bulan)->first();
        $set = Token::where('id_token', 2)->first();
        $usr = DataSiswa::where('id_siswa', $this->id_siswa)
        ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->first();
        // dd($this->id_siswa);
        $text = 'HAPUS Pembayaran SPP siswa '.$usr->nama_lengkap.' kelas '.$usr->tingkat.' '.$usr->singkatan.' '.$usr->nama_kelas.' untuk pembayaran tingkat '.$this->kelas.'/'.$bln->bulan.' sebesar Rp. '.number_format($this->nominal,0,',','.');

        Http::get('https://api.telegram.org/bot'.$set->token.'/sendMessage?chat_id='.$set->chat_id.',&text='.$text);
        ModelsLogSpp::where('id_logspp', $this->id_logspp)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->dispatch('closeModal');
    }

}
