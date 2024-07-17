<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_ujian';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "ujian";
    protected $guarded = [];
}
