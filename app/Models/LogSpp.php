<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSpp extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_logspp';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "log_spp";
    protected $guarded = [];
}
