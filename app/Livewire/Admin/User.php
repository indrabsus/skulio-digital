<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Setingan;
use App\Models\User as TabelUser;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    public $id_role, $username, $id_user;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $role = Role::all();
        $data  = TabelUser::where('username', 'like','%'.$this->cari.'%')
        ->leftJoin('roles','roles.id_role','=','users.id_role')
        ->orderBy('id','desc')
        ->paginate($this->result);
        return view('livewire.admin.user', compact('data','role'));
    }
    public function insert(){
        $this->validate([
            'id_role' => 'required',
            'username'=> 'required'
        ]);
        $pass = Setingan::where('id_setingan',1)->first();
        $user = TabelUser::create([
            'username'=> strtolower(str_replace(' ','', $this->username)),
            'password' => bcrypt($pass->default_password),
            'id_role' => $this->id_role,
            'acc' => 'y'
        ]);
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->id_role = '';
        $this->username = '';
    }
    public function edit($id){
        $data = TabelUser::where('id', $id)->first();
        $this->id_user = $data->id;
        $this->username = $data->username;
        $this->id_role = $data->id_role;
    }
    public function update(){
        $this->validate([
            'id_role' => 'required',
            'username'=> 'required',
        ]);
        $data = TabelUser::where('id', $this->id_user)->update([
            'id_role' => $this->id_role,
            'username'=> $this->username,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_user = $id;
    }
    public function delete(){
        TabelUser::where('id',$this->id_user)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_reset($id){
        $this->id_user = $id;
    }
    public function p_reset(){
        $set = new Controller;
        $set->resetPass($this->id_user);
        session()->flash('sukses','Password berhasil direset');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
