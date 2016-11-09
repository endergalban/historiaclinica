<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habito_fumador extends Model
{
    use SoftDeletes;
	
    protected $table='habito_fumadores';

    protected $fillable = [
        'historia_ocupacional_id','tiempo_fumador_id','cantidad_fumador_id','descripcion'
    ];

    protected $dates = ['deleted_at'];

    public function historia_ocupacional()
    {
        return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
    }

    public function tiempo_fumador()
    {
        return $this->belongsTo('App\Tiempo_fumador','tiempo_fumador_id');
    }

    public function cantidad_fumador()
    {
        return $this->belongsTo('App\Cantidad_fumador','cantidad_fumador_id');
    }

  
}
