<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    // Un rol tiene muchos permisos.
    public function permisos(){
        return $this->belongsToMany(Permission::class);
    }
}
