<?php

namespace App\Livewire\Humas;

use App\Models\Datatamu as IdentitasTamu;
use App\Models\TempatPkl as ModelsTempatPkl;
use App\Models\Token;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class TempatPkl extends Component
{
    public $id_tempat, $tempat_pkl, $alamat;
    public $cari = '';
    public $result = 10;

    public function render()
    {
        $data = ModelsTempatPkl::where('tempat_pkl', 'like', '%' . $this->cari . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->result);

        return view('livewire.humas.tempat-pkl', compact('data'));
    }

    public function insert()
    {
        $this->validate([
            'tempat_pkl' => 'required',
            'alamat' => 'required',
        ]);
            $data = ModelsTempatPkl::create([
                'tempat_pkl' => $this->tempat_pkl,
                'alamat' => $this->alamat,
            ]);

        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm()
    {
        $this->tempat_pkl = '';
        $this->alamat = '';
    }

    public function edit($id)
    {
        $data = ModelsTempatPkl::where('id_tempat', $id)->first();
        $this->tempat_pkl = $data->tempat_pkl;
        $this->alamat = $data->alamat;
        $this->id_tempat = $id;
    }
    public function update()
    {
        $this->validate([
            'tempat_pkl' => 'required',
            'alamat' => 'required',
        ]);
        $data = ModelsTempatPkl::where('id_tempat', $this->id_tempat)->update([
            'tempat_pkl' => $this->tempat_pkl,
            'alamat' => $this->alamat,
        ]);
        session()->flash('sukses', 'Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function c_delete($id)
    {
        $this->id_tempat = $id;
    }
    public function delete()
    {
        ModelsTempatPkl::where('id_tempat', $this->id_tempat)->delete();
        session()->flash('sukses', 'Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
