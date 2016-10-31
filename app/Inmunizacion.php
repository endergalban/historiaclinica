<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inmunizacion extends Model
{
     use SoftDeletes;
	
    protected $table='inmunizaciones';

    protected $fillable = [
        'historia_ocupacional_id','vacuna','dosis','fecha'
    ];

    protected $dates = ['deleted_at','fecha'];

    public function historia_ocupacional()
    {
        return $this->belongTo('App\Historia_ocupacional','historia_ocupacional_id');
    }

   
}
