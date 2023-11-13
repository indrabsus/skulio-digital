<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPeminjamBuku extends Model
{
    use HasFactory;

    protected $table = "daftar_peminjam_buku";
    protected $guarded = [];

}
