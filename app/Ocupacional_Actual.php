<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ocupacional_Actual extends Model
{
	use SoftDeletes;

	protected $table = 'ocupacional_actuales';

    protected $fillable = [
        'historia_ocupacional_id','cargoactual','turno_id','actividad_id',
    ];

    protected $dates = ['deleted_at'];
    

    public function historia_ocupacional()
    {
        return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
    }

    public function turnos()
    {
        return $this->belongsTo('App\Turno','turno_id');
    }

    public function actividades()
    {
        return $this->belongsTo('App\Actividad','actividad_id');
    }

    public function factor_riesgos(){
    	return $this->belongsToMany('App\Factor_riesgo','ocupacional_actual_factor_riesgo','ocupacional_actual_id','factor_riesgo_id')
    }
}
