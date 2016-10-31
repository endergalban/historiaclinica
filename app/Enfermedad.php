<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enfermedad extends Model
{
    use SoftDeletes;
       
	protected $table = 'enfermedades';

	protected $fillable = [
        'descripcion',
    ];
    
    protected $dates = ['deleted_at'];


    public function patologicos()
    {
        return $this->hasMany('App\Patologico','enfermedad_id');
    }

    public function scopeOfType($query, $type){
		
		return $query->where('descripcion', 'like' , '%'.$type.'%');
	}
}
