<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanPpdb extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_jurusan';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "jurusan_ppdb";
    protected $guarded = [];
}
