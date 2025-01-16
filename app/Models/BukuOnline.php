<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuOnline extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_buku_online';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "buku_online";
    protected $guarded = [];
}
