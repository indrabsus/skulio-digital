<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_tugas';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "tugas";
    protected $guarded = [];
}
