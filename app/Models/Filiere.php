<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['nom','type_formation','departement_id'];

    public function departement(){
        return $this -> belongsTo(Departement::class);
    }

    public function etapes(){
        return $this -> hasMany(Etape::class);
    }

    public function seances(){
        return $this -> hasMany(Seance::class);
    }

}
