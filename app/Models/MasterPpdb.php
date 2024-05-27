<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPpdb extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_ppdb';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "master_ppdb";
    protected $guarded = [];
}
