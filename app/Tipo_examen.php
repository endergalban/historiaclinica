<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_examen extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_examenes';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function historia_ocupacionales()
    {
        return $this->hasMany('App\Historia_ocupacional','tipo_examen_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
