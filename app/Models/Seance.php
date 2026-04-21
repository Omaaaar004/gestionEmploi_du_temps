<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = ['jour','heure_deb','heure_fin','semestre','module_id','prof_id','filiere_id','semestre_id','local_id'];

    public function module(){
        return $this->belongsTo(Module::class);
    }

    public function prof(){
        return $this->belongsTo(Prof::class);
    }

    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }

    public function semestre(){
        return $this->belongsTo(Semestre::class);
    }

    public function local(){
        return $this->belongsTo(Locals::class);
    }
}
