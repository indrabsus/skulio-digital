<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentMenu extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_parent';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = "parent_menu";
    protected $guarded = [];
}
