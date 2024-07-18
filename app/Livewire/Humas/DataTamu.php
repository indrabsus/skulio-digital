<?php

namespace App\Livewire\Humas;

use App\Models\Datatamu as IdentitasTamu;
use Livewire\Component;

class DataTamu extends Component
{
    public $id_tamu, $nama, $jenis, $role, $keperluan;
    public $cari = '';
    public $result = 10;

    public function render()
    {
        $data = IdentitasTamu::orderBy('id_tamu')
            ->where('nama', 'like', '%' . $this->cari . '%')
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

        $data = IdentitasTamu::create([
            'nama' => $this->nama,
            'jenis' => $this->jenis,
            'role' => $this->role,
            'keperluan' => $this->keperluan,
        ]);
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
