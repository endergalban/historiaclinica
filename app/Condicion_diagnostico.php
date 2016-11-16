<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condicion_diagnostico extends Model
{
     use SoftDeletes;
	
    protected $table = 'condicion_diagnosticos';

	protected $fillable = [
        'tipo_condicion_id','observacion','historia_ocupacional_id',
    ];
    
    protected $dates = ['deleted_at'];

  	public function historia_ocupacional()
    {
        return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
    }

    public function tipo_condicion()
    {
        return $this->belongsTo('App\Tipo_condicion','tipo_condicion_id');
    }
}
