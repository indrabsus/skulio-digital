<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmitTugas extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_submit';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "submit_tugas";
    protected $guarded = [];
}
