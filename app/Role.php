<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
	use SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
  		'descripcion',
  	];

  	protected $dates = ['deleted_at'];

	public function users(){
		return $this->belongsToMany('App\User','user_role','role_id','user_id');
	}

	public function modulos(){
		return $this->belongsToMany('App\Modulo','role_modulo','role_id','modulo_id');
	}

}
