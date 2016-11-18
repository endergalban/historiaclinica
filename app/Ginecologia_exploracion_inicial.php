<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_exploracion_inicial extends Model
{
    use SoftDeletes;
	
    protected $table='ginecologia_exploracion_inicial';

    protected $fillable = [
		'historia_ginecologica_id','semanaamenorrea', 'sacogestacional', 'formasaco', 'visualizacionembrion', 'numeroembriones', 'actividadmotora', 'actividadcardiaca', 'longitud', 'corionanterior', 'corionposterior', 'corioncervix', 'ecocardiagrama', 'observaciones',
	];

	protected $dates = ['deleted_at'];

	public function historia_ginecologica()
    {
        return $this->belongsTo('App\Historia_ginecologica','historia_ginecologica_id');
    }
}
