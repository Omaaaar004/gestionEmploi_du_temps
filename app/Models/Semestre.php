<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $fillable = ['nom','filiere_id'];

    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }
        
    
    
    public function modules(){
        return $this->hasMany(Module::class);
    }
}
