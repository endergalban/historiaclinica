<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnostico extends Model
{
	use SoftDeletes;
       
	protected $table = 'diagnosticos';

	protected $fillable = [
        'concepto','tipo_diagnostico_id','historia_ocupacional_id'
    ];
    
    protected $dates = ['deleted_at'];

    public function tipo_diagnostico()
    {
        return $this->belongsTo('App\Tipo_diagnostico','tipo_diagnostico_id');
    }

    public function historia_ocupacional()
    {
        return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
    }
       
}
