<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_examen_altura extends Model
{
     use SoftDeletes;

    protected $table = 'tipo_examen_alturas';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function examen_alturas()
    {
        return $this->hasMany('App\Examen_altura','tipo_examen_altura_id');
    }
}
