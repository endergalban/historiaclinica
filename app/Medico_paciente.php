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

    public function citas()
    {
        return $this->hasMany('App\Citas','medico_paciente_id');
    }
    

	public function scopeOfType($query, $type){
		
		return $query->where('descripcion', 'like' , '%'.$type.'%')->orwhere('site', 'like' , '%'.$type.'%');
	}
}
