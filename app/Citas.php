<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    //
    protected $table = 'citas';
    protected $fillable = ['medico_paciente_id','fechainicio','fechafin','color','descripcion'];
    protected $hidden = ['id'];
}
