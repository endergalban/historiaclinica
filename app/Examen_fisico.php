<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examen_fisico extends Model
{
	 use SoftDeletes;
	
    protected $table='examen_fisicos';

    protected $fillable = [
        'historia_ocupacional_id','lateralidad_id','peso','talla','imc','ta','fc','fr',
    ];

    protected $dates = ['deleted_at'];
    
    public function historia_ocupacional(){
		return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
	}
	public function lateralidad(){
		return $this->belongsTo('App\Lateralidad','lateralidad_id');
	}


}
