<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_kelas';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "kelas";
    protected $guarded = [];
}
