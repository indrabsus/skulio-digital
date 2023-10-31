<?php

namespace App\Livewire\Admin;

use App\Models\ParentMenu;
use App\Models\Role;
use Livewire\Component;
use App\Models\Menu as TabelMenu;
use Livewire\WithPagination;

class Menu extends Component
{
    public $id_menu, $path, $class, $name, $parent_menu, $akses_role, $nama_menu, $sort;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $parent = ParentMenu::all();
        $role = Role::all();
        $data  = TabelMenu::leftJoin('parent_menu','parent_menu.id_parent','menu.parent_menu')
        ->leftJoin('roles','roles.id_role','menu.akses_role')
        ->orderBy('sort','asc')
        ->where('nama_menu', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.admin.menu', compact('data','parent','role'));
    }
    public function insert(){
        $this->validate([
            'sort' => 'required|numeric',
            'path' => 'required',
            'class' => 'required',
            'name' => 'required',
            'parent_menu' => 'required',
            'akses_role' => 'required',
            'nama_menu' => 'required',
        ]);
        $data = TabelMenu::create([
            'sort'=> $this->sort,
            'path'=> $this->path,
            'class'=> $this->class,
            'name'=> $this->name,
            'parent_menu'=> $this->parent_menu,
            'akses_role'=> $this->akses_role,
            'nama_menu'=> $this->nama_menu,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->sort = '';
        $this->path = '';
        $this->class = ''; 
        $this->name = '';
        $this->parent_menu = '';
        $this->akses_role = '';
        $this->nama_menu = '';
    }
    public function edit($id){
        $data = TabelMenu::where('id_menu', $id)->first();
        $this->sort = $data->sort;
        $this->path = $data->path;
        $this->class = $data->class;
        $this->name = $data->name;
        $this->parent_menu = $data->parent_menu;
        $this->akses_role = $data->akses_role;
        $this->nama_menu = $data->nama_menu;
        $this->id_menu = $id;
    }
    public function update(){
        $this->validate([
            'sort' => 'required|numeric',
            'path' => 'required',
            'class' => 'required',
            'name' => 'required',
            'parent_menu' => 'required',
            'akses_role' => 'required',
            'nama_menu' => 'required',
        ]);
        $data = TabelMenu::where('id_menu', $this->id_menu)->update([
            'sort'=> $this->sort,
            'path'=> $this->path,
            'class'=> $this->class,
            'name'=> $this->name,
            'parent_menu'=> $this->parent_menu,
            'akses_role'=> $this->akses_role,
            'nama_menu'=> $this->nama_menu,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_menu = $id;
    }
    public function delete(){
        TabelMenu::where('id_menu',$this->id_menu)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
