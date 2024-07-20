<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_token';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "token";
    protected $guarded = [];
}
