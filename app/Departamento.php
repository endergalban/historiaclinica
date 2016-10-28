<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;
	
    protected $table = 'departamentos';

	protected $fillable = [
        'descripcion','abreviado','pais_id',
    ];
    
    protected $dates = ['deleted_at'];

    public function pais()
    {
        return $this->belongsTo('App\Pais');
    }

    public function municipios()
    {
        return $this->hasMany('App\Municipio');
    }
}
