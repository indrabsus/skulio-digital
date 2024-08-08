<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_soal';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "soal";
    protected $guarded = [];
}
