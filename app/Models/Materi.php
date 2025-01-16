<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_materi';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "materi";
    protected $guarded = [];
}
