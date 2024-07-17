<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTabungan extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_log_tabungan';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "log_tabungan";

    protected $guarded = [];
}
