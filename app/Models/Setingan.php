<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setingan extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_setingan';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
    protected $table = 'setingan';
}
