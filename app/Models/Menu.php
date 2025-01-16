<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_menu';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
    protected $table = 'menu';
}
