<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $fillable = ['nom','etape_id'];
    
    public function etape(){
        return $this->belongsTo(Etape::class);
    }
    public function modules(){
        return $this->hasMany(Module::class);
    }
}
