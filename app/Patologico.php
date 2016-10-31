<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patologico extends Model
{
    use SoftDeletes;
       
	protected $table = 'patologicos';

	protected $fillable = [
        'historial_ocupacional_id','enfermedad_id','observacion','familiar','personal'
    ];
    
    protected $dates = ['deleted_at'];


    public function historia_ocupacional()
    {
        return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
    }
}
