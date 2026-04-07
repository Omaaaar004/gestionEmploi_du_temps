<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prof extends Model
{
    protected $fillable = ['nom','prenom','specialite','email','departement_id'];

    public function departemen(){
        return $this -> belongsTo(Departement::class);
    }

    public function seances(){
        return $this -> hasMany(Seance::class);
    }

}
