<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaBaru extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_siswa_baru';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "siswa_baru";
    protected $guarded = [];
}
