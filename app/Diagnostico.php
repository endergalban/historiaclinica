<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnostico extends Model
{
	use SoftDeletes;
       
	protected $table = 'diagnosticos';

	protected $fillable = [
        'nombre','codigo','concepto',
    ];
    
    protected $dates = ['deleted_at'];


    public function historia_ocupacionales()
    {
        return $this->belongsToMany('App\Historia_ocupacional','historia_ocupacional_diagnostico','diagnostico_id','historia_ocupacional_id');
    }
       
}
