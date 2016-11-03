<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cantidad_fumador extends Model
{
	use SoftDeletes;
	
    protected $table='cantidad_fumadores';

    protected $fillable = [
        'descripcion',
    ];

    public function habito_fumadores()
    {
        return $this->hasMany('App\Habito_fumador','cantidad_fumador_id');
    }

    protected $dates = ['deleted_at'];

  	public function scopeOfType($query, $type){
		
		return $query->where('descripcion', 'like' , '%'.$type.'%');
	}
}
