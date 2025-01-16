<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTabungan extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_laporan';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "laporan_tabungan";
    protected $guarded = [];
}
