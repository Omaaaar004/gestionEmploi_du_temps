<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    protected $fillable = ['nom','niveau','filiere_id'];

    public function etape(){
        return $this -> belongsTo(Etape::class);
    } 

    public function modules(){
        return $this -> hasMany(Module::class);
    }

}
