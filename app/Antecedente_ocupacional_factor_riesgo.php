<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Antecedente_ocupacional_factor_riesgo extends Model
{
   use SoftDeletes;

	protected $table = 'antecedente_ocupacional_factor_riesgo';

    protected $fillable = [
        'antecedente_ocupacional_id','factor_riesgo_id','medidacontrol', 'tiempoexposicion', 'otro' ];

    protected $dates = ['deleted_at'];
    
 	public function antecedente_ocupacional()
    {
        return $this->belongsTo('App\Antecedente_ocupacional','antecedente_ocupacional_id');
    }

    public function factor_riesgo()
    {
        return $this->belongsTo('App\Factor_riesgo','factor_riesgo_id');
    }
}
