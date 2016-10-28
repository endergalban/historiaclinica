<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipio extends Model
{
    use SoftDeletes;
	protected $table = 'municipios';

    protected $fillable = [
        'descripcion','abreviado','departamento_id',
    ];

    protected $dates = ['deleted_at'];

    public function departamento()
    {
        return $this->belongsTo('App\Departamento');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

     public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }
    
}
