<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Role as TabelRole;
use Livewire\WithPagination;

class Role extends Component
{
    public $nama_role, $id_role;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelRole::orderBy('id_role','desc')->where('nama_role', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.admin.role', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nama_role' => 'required'
        ]);
        $data = TabelRole::create([
            'nama_role' => strtolower($this->nama_role)
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_role = '';
    }
    public function edit($id){
        $data = TabelRole::where('id_role', $id)->first();
        $this->nama_role = $data->nama_role;
        $this->id_role = $data->id_role;
    }
    public function update(){
        $this->validate([
            'nama_role' => 'required'
        ]);
        $data = TabelRole::where('id_role', $this->id_role)->update([
            'nama_role' => strtolower($this->nama_role),
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_role = $id;
    }
    public function delete(){
        TabelRole::where('id_role',$this->id_role)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
