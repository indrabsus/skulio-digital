<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppPengaturan extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_spp_pengaturan';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "spp_pengaturan";
    protected $guarded = [];
}
