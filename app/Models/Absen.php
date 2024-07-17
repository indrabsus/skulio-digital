<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_absen';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "absen";
    protected $guarded = [];
}
