<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examen_altura extends Model
{
     use SoftDeletes;
	
    protected $table='examen_alturas';

    protected $fillable = [
        'historia_ocupacional_id','tipo_examen_altura_id','observacion',
    ];

    protected $dates = ['deleted_at'];
    
    public function historia_ocupacional(){
		return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
	}
	public function tipo_examen_altura(){
		return $this->belongsTo('App\Tipo_examen_altura','tipo_examen_altura_id');
	}
}
