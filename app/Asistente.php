<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asistente extends Model
{
    use SoftDeletes;

    protected $table = 'asistentes';

	protected $fillable = [
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function medicos()
    {
        return $this->belongsToMany('App\Medico','asistente_medico','asistente_id','medico_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('numerodocumento', 'like' , '%'.$type.'%')->orwhere('primernombre', 'like' , '%'.$type.'%')->orwhere('primerapellido', 'like' , '%'.$type.'%');
    }
}
