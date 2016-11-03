<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lateralidad extends Model
{
    use SoftDeletes;

    protected $table = 'lateralidades';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function examen_fisicos()
    {
        return $this->hasMany('App\Examen_fisico','lateralidad_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
