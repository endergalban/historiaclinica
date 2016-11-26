<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Medico_paciente extends Model
{
    use SoftDeletes;

    protected $table = 'medico_pacientes';

    protected $fillable = [
  		'medico_id','paciente_id','especialidad_id',
  	];

  	protected $dates = ['deleted_at'];

	public function historia_ocupacionales(){
		return $this->hasMany('App\Historia_ocupacional','medico_paciente_id');
	}

	public function paciente()
    {
        return $this->belongsTo('App\Paciente','paciente_id');
    }


 	public function medico()
    {
        return $this->belongsTo('App\Medico','medico_id');
    }

    public function especialidad()
    {
        return $this->belongsTo('App\Especialidad','especialidad_id');
    }

    public function citas()
    {
        return $this->hasMany('App\Citas','medico_paciente_id');
    }

    public function historia_ginecologicas()
    {
        return $this->hasMany('App\Historia_ginecologica','medico_paciente_id');
    }

    public function ginecologia_ginecobstetrico()
    {
        return $this->hasOne('App\Ginecologia_ginecobstetrico','medico_paciente_id');
    }

    public function ginecologia_antecedente()
    {
        return $this->hasOne('App\Ginecologia_antecedente','medico_paciente_id');
    }

    public function ginecologia_exploracion_iniciales()
    {
        return $this->hasMany('App\Ginecologia_exploracion_inicial','medico_paciente_id');
    }

   
	public function scopeOfType($query, $type){
		
		return $query->where('descripcion', 'like' , '%'.$type.'%')->orwhere('site', 'like' , '%'.$type.'%');
	}
}
