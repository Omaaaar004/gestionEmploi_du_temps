<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $fillable = ['nom','composante_id'];

    public function composante(){
        return $this -> belongsTo(Departement::class);
    }
    
    public function filieres(){
        return $this  -> hasMany(Filiere::class);
    }

    public function profs(){
        return $this -> hasMany(Prof::class);
    }

}
