<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividad extends Model
{
    use SoftDeletes;

    protected $table = 'actividades';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function historia_ocupacionales()
    {
        return $this->hasMany('App\Historia_ocupacional','actividad_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
