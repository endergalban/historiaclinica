<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factor_riesgo extends Model
{
    use SoftDeletes;

    protected $table = 'factor_riesgos';

    protected $fillable = [
        'tipo_factor_riesgo_id','descripcion'
    ];

    protected $dates = ['deleted_at'];

	public function tipo_factor_riesgo(){
		return $this->belongsTo('App\Tipo_factor_riesgo','tipo_factor_riesgo_id');
	}

	public function historia_ocupacionales(){
		return $this->belongsToMany('App\Historia_ocupacional','historia_ocupacional_factor_riesgo','factor_riesgo_id','historia_ocupacional_id');
	}
}
