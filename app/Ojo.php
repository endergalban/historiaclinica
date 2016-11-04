<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ojo extends Model
{
     use SoftDeletes;
       
	protected $table = 'ojos';

	protected $fillable = [
        'descripcion',
    ];
    
    protected $dates = ['deleted_at'];


    public function examen_visuales()
    {
        return $this->hasMany('App\Examen_visual','ojo_id');
    }
}
