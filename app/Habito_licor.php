<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habito_licor extends Model
{
    use SoftDeletes;
	
    protected $table='habito_licores';

    protected $fillable = [
        'historia_ocupacional_id','tiempo_licor_id','tipolicor',
    ];

    protected $dates = ['deleted_at'];

    public function historia_ocupacional()
    {
        return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
    }

    public function tiempo_licor()
    {
        return $this->belongsTo('App\Tiempo_licor','tiempo_licor_id');
    }

   
}
