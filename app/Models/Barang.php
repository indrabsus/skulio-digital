<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_barang';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "barang";
    protected $guarded = [];
}
