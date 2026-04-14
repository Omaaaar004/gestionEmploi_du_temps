<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    protected $fillable = ['nom','niveau','filiere_id'];

    public function filiere(){
        return $this -> belongsTo(Filiere::class);
    } 

    public function modules(){
        return $this -> hasMany(Module::class);
    }

}
