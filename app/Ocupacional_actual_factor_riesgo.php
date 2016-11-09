<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ocupacional_actual_factor_riesgo extends Model
{
    use SoftDeletes;

	protected $table = 'ocupacional_actual_factor_riesgo';

    protected $fillable = [
        'ocupacional_actual_id','factor_riesgo_id','medidacontrol', 'tiempoexposicion', 'otro' ];

    protected $dates = ['deleted_at'];
    
 	public function ocupacional_actual()
    {
        return $this->belongsTo('App\Ocupacional_actual','ocupacional_actual_id');
    }

    public function factor_riesgo()
    {
        return $this->belongsTo('App\Factor_riesgo','factor_riesgo_id');
    }

}
