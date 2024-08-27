<?php

namespace App\Livewire\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\Absen as ModelsAbsen;
use App\Models\Role;
use Livewire\Component;
use App\Models\DataUser;
use App\Models\User;
use Livewire\WithPagination;
use Rats\Zkteco\Lib\ZKTeco;

class DataLogFingerprint extends Component
{
    public $id_role, $id_absen, $nama_lengkap, $jenkel, $no_hp, $alamat, $id_user, $status, $waktu;
    use WithPagination;

    public $cari = '';
    public $result = 10;
    public function render()
    {
        $zk = new ZKTeco('192.168.107.99');
        $konek = $zk->connect();
        $data = $zk->getAttendance();

        return view('livewire.manajemen.data-log-fingerprint', compact('data'));
    }
    public function tarik(){
        $zk = new ZKTeco('192.168.107.99');
        $zk->connect();

        foreach($zk->getAttendance() as $g => $d){
            // Mendapatkan hari dalam format numerik, 6 untuk Sabtu dan 7 untuk Minggu
            $dayOfWeek = date('N', strtotime($d['timestamp']));

            // Jika hari adalah Sabtu atau Minggu, lewati iterasi ini
            if ($dayOfWeek == 6 || $dayOfWeek == 7) {
                continue;
            }

            // Mendapatkan data user berdasarkan UID fingerprint
            $data = DataUser::leftJoin('users', 'users.id', 'data_user.id_user')
                ->where('data_user.uid_fp', $d['uid'])->first();

            if ($data) {
                // Memisahkan tanggal dari timestamp
                $date = date('Y-m-d', strtotime($d['timestamp']));

                // Cek apakah data absen sudah ada di database untuk tanggal tersebut
                $hitung = ModelsAbsen::where('id_user', $data->id_user)
                    ->where('status', $d['type'])
                    ->whereDate('waktu', $date)
                    ->count();

                // Jika data belum ada, buat entri baru
                if ($hitung < 1) {
                    if ($data->id_role == 6) {
                        // Jika id_role == 6, cek ulang apakah sudah ada data untuk hari yang sama
                        $existingData = ModelsAbsen::where('id_user', $data->id_user)
                            ->whereDate('waktu', $date)
                            ->first();

                        if (!$existingData) {
                            ModelsAbsen::create([
                                'id_user' => $data->id_user,
                                'status' => 0,
                                'waktu' => $d['timestamp']
                            ]);
                        }
                    } else {
                        ModelsAbsen::create([
                            'id_user' => $data->id_user,
                            'status' => $d['type'] == 0 ? 0 : 4,
                            'waktu' => $d['timestamp']
                        ]);
                    }
                } else {
                    // Jika sudah ada data untuk tanggal tersebut, tambahkan data baru
                    // hanya jika tanggalnya berubah.
                    $existingData = ModelsAbsen::where('id_user', $data->id_user)
                        ->where('status', $d['type'])
                        ->whereDate('waktu', '<>', $date)
                        ->first();

                    if (!$existingData) {
                        ModelsAbsen::create([
                            'id_user' => $data->id_user,
                            'status' => $d['type'] == 0 ? 0 : 4,
                            'waktu' => $d['timestamp']
                        ]);
                    }
                }
            }
        }

        // Hanya menghapus data kehadiran dari mesin setelah iterasi selesai
        $zk->clearAttendance();
        session()->flash('sukses', 'Data berhasil ditarik');
        $this->clearForm();
        $this->dispatch('closeModal');
    }

    public function clearForm(){
        $this->id_role = '';
        $this->id_user = '';
        $this->status = '';
        $this->no_hp = '';
        $this->alamat = '';
        $this->waktu = '';
    }
    public function izin(){
        $this->validate([
            'id_user' => 'required',
            'status' => 'required',
        ]);
        $hitung = ModelsAbsen::where('id_user', $this->id_user)
            ->where('waktu', 'like','%'.date('Y-m-d').'%')
            ->count();
        $pulang = ModelsAbsen::where('id_user', $this->id_user)
            ->where('waktu', 'like','%'.date('Y-m-d').'%')
            ->where('status', 4)
            ->count();
            if($hitung < 1) {
                ModelsAbsen::create([
                    'id_user' => $this->id_user,
                    'status' => $this->status,
                    'waktu' => now()
                ]);
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
            }
            else {
                if($pulang < 1) {
                    if($this->status == 4){
                        ModelsAbsen::create([
                            'id_user' => $this->id_user,
                            'status' => $this->status,
                            'waktu' => now()
                        ]);
                session()->flash('sukses','Data berhasil ditambahkan');
                $this->clearForm();
                $this->dispatch('closeModal');
                    } else {
                        session()->flash('gagal','Data Gagal ditambahkan');
                $this->clearForm();
                $this->dispatch('closeModal');
                    }
                } else {
                    session()->flash('gagal','Data Gagal ditambahkan');
                $this->clearForm();
                $this->dispatch('closeModal');
                }
            }

    }
    public function hadir(){
        $this->validate([
            'id_user' => 'required',
        ]);

        $hitung = ModelsAbsen::where('id_user', $this->id_user)
            ->where('waktu', 'like','%'.date('Y-m-d').'%')
            ->count();
            if($hitung < 1) {
                if($this->waktu == NULL){
                    ModelsAbsen::create([
                        'id_user' => $this->id_user,
                        'status' => $this->status,
                        'waktu' => now()
                    ]);
            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
                } else {
                    ModelsAbsen::create([
                        'id_user' => $this->id_user,
                        'status' => 0,
                        'waktu' => $this->waktu
                    ]);
            session()->flash('sukses','Data berhasil ditambahkan');
            $this->clearForm();
            $this->dispatch('closeModal');
                }

            } else {
                session()->flash('gagal','Data Gagal ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
            }
    }
    public function update(){
        $this->validate([
            'id_user' => 'required',
            'nama_lengkap'=> 'required',
            'jenkel' => 'required',
            'no_hp'=> 'required',
            'alamat'=> 'required',
        ]);
        $data = TabelDataUser::where('id_data', $this->id_data)->update([
            'id_user' => $this->id_user,
            'nama_lengkap'=> $this->nama_lengkap,
            'jenkel'=> $this->jenkel,
            'no_hp'=> $this->no_hp,
            'alamat'=> $this->alamat
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_absen = $id;
    }
    public function delete(){
        ModelsAbsen::where('id_absen',$this->id_absen)->delete();

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
