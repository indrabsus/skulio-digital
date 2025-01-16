<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JwbnRefleksi extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_jawaban';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "jwbn_refleksi";
    protected $guarded = [];
}
