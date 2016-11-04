<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Antecedente_ocupacional extends Model
{
   use SoftDeletes;

    protected $table = 'antecedente_ocupacionales';

     

	protected $fillable = [
        'historia_ocupacional_id','empresa','tiemposervicio','ocupacion',
    ];

    protected $dates = ['deleted_at'];

    public function historia_ocupacional()
    {
        return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
    }

    public function traumatologicos()
    {
        return $this->hasMany('App\Traumatologico','antecedente_ocupacional_id');
    }

    public function factor_riesgos(){
    	return $this->belongsToMany('App\Factor_riesgo','antecedente_ocupacional_factor_riesgo','antecedente_ocupacional_id','factor_riesgo_id');
    }

  
}
