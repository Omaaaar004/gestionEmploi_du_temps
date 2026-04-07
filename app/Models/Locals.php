<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locals extends Model
{
    protected $fillable = ['nom_local','capacite','zone_id'];
    
    public function zone(){
        return $this -> belongsTo(Zone::class);
        
    }

    public function seances(){
        return $this -> hasMany(Seance::class);
    }


}
    
