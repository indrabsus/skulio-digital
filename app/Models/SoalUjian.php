<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalUjian extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_soalujian';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "soal_ujian";
    protected $guarded = [];
}
