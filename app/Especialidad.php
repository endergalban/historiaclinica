<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidad extends Model
{
	use SoftDeletes;

    protected $table = 'especialidades';

    protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

	public function medicos(){
		return $this->belongsToMany('App\Medico','especialidad_medico','especialidad_id','medico_id');
	}

	public function medico_pacientes(){
		return $this->hasMany('App\Medico_pacientes','especialidad_id');
	}


	public function scopeOfType($query, $type){
		
		return $query->where('descripcion', 'like' , '%'.$type.'%');
	}
}
