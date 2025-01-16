<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSoal extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_kategori';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "kategori_soal";
    protected $guarded = [];
}
