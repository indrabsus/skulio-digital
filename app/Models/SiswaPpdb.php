<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaPpdb extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_siswa';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "siswa_ppdb";
    protected $guarded = [];
}
