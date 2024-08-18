<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSpp extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_spp';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "master_spp";
    protected $guarded = [];
}
