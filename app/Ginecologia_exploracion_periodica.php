<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_exploracion_periodica extends Model
{
	use SoftDeletes;
	
    protected $table='ginecologia_exploracion_periodicas';

    protected $fillable = [
		'historia_ginecologica_id','ginecologia_exploracion_periodo_id','peso','semanaamenorrea', 'situacionfetal', 'dorso', 'dbp', 'lf', 'pabdominal', 'actividadmotora', 'actividadcardiaca', 'actividadrespiratoria', 'semanaecografia', 'corionanterior', 'localizacion', 'madurez', 'liquidovolumen', 'liquidoobservaciones', 
	]

	protected $dates = ['deleted_at'];

	public function historia_ginecologica()
    {
        return $this->belongsTo('App\Historia_ginecologica','historia_ginecologica_id');
    }
    
    public function ginecologia_exploracion_periodo()
    {
        return $this->belongsTo('App\Ginecologia_exploracion_periodo','ginecologia_exploracion_periodo_id');
    }

}
