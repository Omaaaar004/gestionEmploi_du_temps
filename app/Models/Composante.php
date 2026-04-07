<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Composante extends Model
{
    protected $fillable = ['nom','adresse'];
    public function departements(){
        return $this->hasMany(Departement::class);
    }
}
