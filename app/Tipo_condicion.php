<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_condicion extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_condiciones';

	protected $fillable = [
        'descripcion','tipo_examen_id',
    ];

    protected $dates = ['deleted_at'];

    public function tipo_examen()
    {
        return $this->belongsTo('App\Tipo_examen','tipo_examen_id');
    }

    public function condicion_diagnosticos()
    {
        return $this->hasMany('App\Condicion_diagnostico','tipo_condicion_id');
    }

    public function condicion_alturas()
    {
        return $this->hasMany('App\Condicion_altura','tipo_condicion_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
