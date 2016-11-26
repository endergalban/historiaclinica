<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_exploracion_inicial extends Model
{
    use SoftDeletes;
	
    protected $table='ginecologia_exploracion_iniciales';

    protected $fillable = [
		'medico_paciente_id','semanaamenorrea', 'sacogestacional', 'formasaco', 'visualizacionembrion', 'numeroembriones', 'actividadmotora', 'actividadcardiaca', 'longitud', 'corionanterior', 'corionposterior', 'corioncervix', 'ecocardiagrama', 'observaciones','fechaparto',
	];

	protected $dates = ['deleted_at','fechaparto'];

	public function medico_paciente()
    {
        return $this->belongsTo('App\Medico_paciente','medico_paciente_id');
    }

     public function ginecologia_exploracion_periodicas()
    {
        return $this->hasMany('App\Ginecologia_exploracion_periodica','ginecologia_exploracion_inicial_id');
    }
}
