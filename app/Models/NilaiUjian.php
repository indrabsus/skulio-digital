<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiUjian extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_nilaiujian';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "nilai_ujian";
    protected $guarded = [];
}
