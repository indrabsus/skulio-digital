<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_mapel';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "mata_pelajaran";
    protected $guarded = [];
}
