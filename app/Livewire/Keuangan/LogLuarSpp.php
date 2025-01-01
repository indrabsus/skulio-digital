<?php

namespace App\Livewire\Keuangan;

use App\Models\DataSiswa;
use App\Models\LogLuarSpp as ModelsLogLuarSpp;
use App\Models\LogSpp as ModelsLogSpp;
use App\Models\SppPengaturan;
use App\Models\Token;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class LogLuarSpp extends Component
{
    public  $nominal, $keterangan, $via, $status, $id_logluar, $created_at;
    use WithPagination;
    public $bln ='';
    public $thn='';
    public $cari = '';
    public $result = 10;

    public function render()
    {
        $data = ModelsLogLuarSpp::orderBy('created_at','desc')
        ->where('keterangan', 'like','%'.$this->cari.'%')
        ->paginate($this->result);
            return view('livewire.keuangan.log-luar-spp', compact('data'));
    }
    public function create(){
        $this->validate([
            'keterangan' => 'required',
            'nominal' => 'required',
            'status' => 'required',
            'via' => 'required',
        ]);
        $data = ModelsLogLuarSpp::create([
            'keterangan' => $this->keterangan,
            'nominal' => $this->nominal,
            'status' => $this->status,
            'via' => $this->via,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->keterangan = '';
        $this->nominal = '';
        $this->status = '';
        $this->via = '';
    }
    public function edit($id){
        $data = ModelsLogLuarSpp::where('id_logluar', $id)->first();
        $this->id_logluar = $id;
        $this->keterangan = $data->keterangan;
        $this->nominal = $data->nominal;
        $this->status = $data->status;
        $this->via = $data->via;
        $this->created_at = $data->created_at;
    }
    public function update(){
        $this->validate([
            'keterangan' => 'required',
            'nominal' => 'required',
            'status' => 'required',
            'via' => 'required',
        ]);
        $data = ModelsLogLuarSpp::where('id_logluar', $this->id_logluar)->update([
            'created_at' => $this->created_at,
            'keterangan' => $this->keterangan,
            'nominal' => $this->nominal,
            'status' => $this->status,
            'via' => $this->via

        ]);
        session()->flash('sukses','Data berhasil diedit');
        // $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function k_delete($id){
        $data = ModelsLogLuarSpp::where('id_logluar', $id)->first();
        $this->id_logluar = $id;
    }
    public function delete(){
        $set = SppPengaturan::where('id_spp_pengaturan', '1234awal')->first();

        ModelsLogLuarSpp::where('id_logluar', $this->id_logluar)->delete();
        Http::get('https://api.telegram.org/bot'.$set->token_telegram.'/sendMessage?chat_id='.$set->chat_id.',&text=Log Luar SPP berhasil dihapus');
        session()->flash('sukses','Data berhasil dihapus');
        $this->dispatch('closeModal');
    }

}
