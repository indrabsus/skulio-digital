<?php

namespace App\Livewire\Humas;

use App\Models\Datatamu as IdentitasTamu;
use App\Models\Token;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class DataTamu extends Component
{
    public $id_tamu, $nama, $jenis, $role, $keperluan, $nama_instansi;
    public $cari = '';
    public $result = 10;

    public function render()
    {
        $data = IdentitasTamu::where('nama', 'like', '%' . $this->cari . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->result);

        return view('livewire.humas.data-tamu', compact('data'));
    }

    public function insert()
    {
        $this->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'role' => 'required',
            'keperluan' => 'required',
        ]);
        if($this->jenis == 'i'){
            $data = IdentitasTamu::create([
                'nama' => $this->nama,
                'jenis' => $this->jenis,
                'role' => $this->role.' - '.$this->nama_instansi,
                'keperluan' => $this->keperluan,
            ]);
        } else {
            $data = IdentitasTamu::create([
                'nama' => $this->nama,
                'jenis' => $this->jenis,
                'role' => $this->role,
                'keperluan' => $this->keperluan,
            ]);
        }


        $set = Token::where('id_token', 1)->first();
        if($this->jenis == 'i'){
            $text = "Ada tamu baru atas nama ".$this->nama." (". $this->role." - ".$this->nama_instansi.") dengan keperluan ".$this->keperluan;
        } else {
            $text = "Ada tamu baru atas nama ".$this->nama." (". $this->role.") dengan keperluan ".$this->keperluan;
        }
        Http::get('https://api.telegram.org/bot'.$set->token.'/sendMessage?chat_id='.$set->chat_id.',&text='.$text);
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm()
    {
        $this->nama = '';
        $this->jenis = '';
        $this->role = '';
        $this->keperluan = '';
    }

    public function edit($id)
    {
        $data = IdentitasTamu::where('id_tamu', $id)->first();
        $this->id_tamu = $id;
        $this->nama = $data->nama;
        $this->jenis = $data->jenis;
        $this->role = $data->role;
        $this->keperluan = $data->keperluan;
    }
    public function update()
    {
        $this->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'role' => 'required',
            'keperluan' => 'required',
        ]);
        $data = IdentitasTamu::where('id_tamu', $this->id_tamu)->update([
            'nama' => $this->nama,
            'jenis' => $this->jenis,
            'role' => $this->role,
            'keperluan' => $this->keperluan,
        ]);
        session()->flash('sukses', 'Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function c_delete($id)
    {
        $this->id_tamu = $id;
    }
    public function delete()
    {
        IdentitasTamu::where('id_tamu', $this->id_tamu)->delete();
        session()->flash('sukses', 'Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
