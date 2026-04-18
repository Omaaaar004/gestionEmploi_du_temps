<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $fillable = ['nom'];
    
    public function modules(){
        return $this->hasMany(Module::class);
    }
}
