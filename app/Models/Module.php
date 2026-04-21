<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['nom','filiere_id','semestre_id'];
    
    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }
    


   public function semestre(){
        return $this-> belongsTo(Semestre::class);
   }

    public function seances(){
        return $this -> hasMany(Seance::class);
    }

}
