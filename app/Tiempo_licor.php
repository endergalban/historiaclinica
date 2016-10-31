<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tiempo_licor extends Model
{
    use SoftDeletes;
       
	protected $table = 'tiempo_licores';

	protected $fillable = [
        'descripcion',
    ];
    
    protected $dates = ['deleted_at'];


    public function habito_licores()
    {
        return $this->hasMany('App\Habito_licor','tiempo_licor_id');
    }
}
