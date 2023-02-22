<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['permission'];

    // un permiso puede estar en multiples roles
    public function Roles(){
        return $this->belongsToMany(Role::class);
    }
}
