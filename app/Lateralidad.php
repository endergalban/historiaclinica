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

    public function historia_ocupacionales()
    {
        return $this->hasMany('App\Historia_ocupacional','lateralidad_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
