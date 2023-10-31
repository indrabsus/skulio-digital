<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ParentMenu as TabelParent;
use Livewire\WithPagination;

class ParentMenu extends Component
{
    public $parent_menu, $id_parent, $icon;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelParent::where('parent_menu', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.admin.parent-menu', compact('data'));
    }
    public function insert(){
        $this->validate([
            'parent_menu' => 'required',
            'icon' => 'required'
        ]);
        $data = TabelParent::create([
            'parent_menu' => strtolower($this->parent_menu),
            'icon'=> $this->icon,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->parent_menu = '';
        $this->icon = '';
    }
    public function edit($id){
        $data = TabelParent::where('id_parent', $id)->first();
        $this->parent_menu = $data->parent_menu;
        $this->icon = $data->icon;
        $this->id_parent = $data->id_parent;
    }
    public function update(){
        $this->validate([
            'parent_menu' => 'required',
            'icon' => 'required'
        ]);
        $data = TabelParent::where('id_parent', $this->id_parent)->update([
            'parent_menu' => strtolower($this->parent_menu),
            'icon'=> $this->icon,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_parent = $id;
    }
    public function delete(){
        TabelParent::where('id_parent',$this->id_parent)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
