<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_pengajuan';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "pengajuan";
    protected $guarded = [];
}
