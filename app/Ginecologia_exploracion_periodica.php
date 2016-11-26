<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_exploracion_periodica extends Model
{
	use SoftDeletes;
	
    protected $table='ginecologia_exploracion_periodicas';

    protected $fillable = [
		'ginecologia_exploracion_inicial_id','ginecologia_exploracion_periodo_id','semanaamenorrea', 'situacionfetal', 'dorso', 'dbp', 'lf', 'pabdominal', 'actividadmotora', 'actividadcardiaca', 'actividadrespiratoria', 'semanaecografia', 'corionanterior', 'localizacion', 'madurez', 'liquidovolumen', 'liquidoobservaciones', 
	];

	protected $dates = ['deleted_at'];

	public function ginecologia_exploracion_inicial()
    {
        return $this->belongsTo('App\Ginecologia_exploracion_inicial','ginecologia_exploracion_inicial_id');
    }
    
    public function ginecologia_exploracion_periodo()
    {
        return $this->belongsTo('App\Ginecologia_exploracion_periodo','ginecologia_exploracion_periodo_id');
    }

}
