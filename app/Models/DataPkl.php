<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPkl extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_pkl';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "data_pkl";
    protected $guarded = [];
}
