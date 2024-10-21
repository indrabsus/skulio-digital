<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    use HasFactory;
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_jawabansiswa';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "jawaban_siswa";
    protected $guarded = [];
}
