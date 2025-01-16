<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenHarianSiswa extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_harian';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "absen_harian_siswa";
    protected $guarded = [];
}
