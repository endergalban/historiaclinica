<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pais extends Model
{
	use SoftDeletes;

    protected $table = 'paises';

	 protected $fillable = [
        'descripcion','abreviado',
    ];

    protected $dates = ['deleted_at'];

    public function departamentos()
    {
        return $this->hasMany('App\Departamento');
    }
}
