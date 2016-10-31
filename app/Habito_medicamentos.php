<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habito_medicamentos extends Model
{
    use SoftDeletes;
	
    protected $table='habito_medicamentos';

    protected $fillable = [
        'historia_ocupacional_id','regularidad_medicamento_id','nombremedicamento',
    ];

    protected $dates = ['deleted_at'];

    public function historia_ocupacional()
    {
        return $this->belongTo('App\Historia_ocupacional','historia_ocupacional_id');
    }

    public function regularidad_medicamento()
    {
        return $this->belongTo('App\Regularidad_medicamento','regularidad_medicamento_id');
    }

   
}
