<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_exploracion_periodo extends Model
{
    
    protected $table = 'ginecologia_exploracion_periodos';

    protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

	public function ginecologia_exploracion_periodicas(){
		return $this->hasMany('App\Ginecologia_exploracion_periodica','ginecologia_exploracion_periodica_id');
	}


	public function scopeOfType($query, $type){
		
		return $query->where('descripcion', 'like' , '%'.$type.'%');
	}
}
