<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refleksi extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_refleksi';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "refleksi";
    protected $guarded = [];
}
