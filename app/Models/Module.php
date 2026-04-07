<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['nom','etape_id'];

    public function etape(){
        return $this -> belongsTo(Etape::class);
    }

    public function seances(){
        return $this -> hasMany(Seance::class);
    }

}
