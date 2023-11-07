<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTabungan extends Model
{
    use HasFactory;
    protected $table = "log_tabungan";
    
    protected $guarded = [];
}
