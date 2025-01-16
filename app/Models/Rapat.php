<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapat extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_rapat';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "rapat";
    protected $guarded = [];
}
