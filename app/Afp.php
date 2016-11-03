<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Afp extends Model
{
    use SoftDeletes;
	
    protected $table = 'afps';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'descripcion',
    ];

    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }

    public function historia_ocupacionales()
    {
        return $this->hasMany('App\Historia_ocupacional','afp_id');
    }

    public function scopeOfType($query, $type){
		
		return $query->where('descripcion', 'like' , '%'.$type.'%');
	}
}
