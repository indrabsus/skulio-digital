<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sumatif extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_sumatif';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "sumatif";
    protected $guarded = [];
}
