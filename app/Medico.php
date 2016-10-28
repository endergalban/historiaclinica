<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medico extends Model
{
    use SoftDeletes;

    protected $table = 'medicos';

	protected $fillable = [
        'user_id','registro','banner',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function especialidades()
    {
        return $this->belongsToMany('App\Especialidad','especialidad_medico','medico_id','especialidad_id');
    }

    public function asistentes()
    {
        return $this->belongsToMany('App\Asistente','asistente_medico','medico_id','asistente_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('numerodocumento', 'like' , '%'.$type.'%')->orwhere('primernombre', 'like' , '%'.$type.'%')->orwhere('primerapellido', 'like' , '%'.$type.'%');
    }
}
