<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['nom_zone','code_zone','description'];
    public function locals(){
        return $this -> hasMany(Local::class);
    }
}
