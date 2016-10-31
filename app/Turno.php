<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Turno extends Model
{
    use SoftDeletes;

    protected $table = 'turnos';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function historia_ocupacionales()
    {
        return $this->hasMany('App\Historia_ocupacional','turno_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
