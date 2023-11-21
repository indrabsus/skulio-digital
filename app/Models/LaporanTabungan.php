<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTabungan extends Model
{
    use HasFactory; 

    protected $table = "laporan_tabungan";
    protected $guarded = [];
}
