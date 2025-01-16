<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelKelas extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_mapelkelas';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
    protected $table = 'mapel_kelas';
}
