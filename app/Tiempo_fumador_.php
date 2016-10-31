<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tiempo_fumador_ extends Model
{
    use SoftDeletes;
       
	protected $table = 'tiempo_fumadores';

	protected $fillable = [
        'descripcion',
    ];
    
    protected $dates = ['deleted_at'];


    public function habito_fumadores()
    {
        return $this->hasMany('App\Habito_fumador','tiempo_fumador_id');
    }
}
