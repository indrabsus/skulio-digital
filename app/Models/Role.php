<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'id_role';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    protected $table = 'roles';
}
