<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modulo extends Model
{
    use SoftDeletes;

    protected $table = 'modulos';

    protected $fillable = [
  		'site','icono','orden','descripcion','visible',
  	];

  	protected $dates = ['deleted_at'];

	public function roles(){
		return $this->belongsToMany('App\Role','role_modulo','modulo_id','role_id');
	}

	public function scopeOfType($query, $type){
		
		return $query->where('descripcion', 'like' , '%'.$type.'%')->orwhere('site', 'like' , '%'.$type.'%');
	}

}

