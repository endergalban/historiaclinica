<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnostico extends Model
{
	use SoftDeletes;
       
	protected $table = 'diagnosticos';

	protected $fillable = [
        'concepto','id_tipo_diagnostico'
    ];
    
    protected $dates = ['deleted_at'];

    public function tipo_diagnostico()
    {
        return $this->belongs('App\Tipo_diagnostico','id_tipo_diagnostico');
    }

    public function historia_ocupacionales()
    {
        return $this->belongsToMany('App\Historia_ocupacional','historia_ocupacional_diagnostico','diagnostico_id','historia_ocupacional_id');
    }
       
}
