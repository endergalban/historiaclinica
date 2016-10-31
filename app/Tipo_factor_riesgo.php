<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_factor_riesgo extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_factor_riesgos';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function factor_riesgos()
    {
        return $this->hasMany('App\factor_riesgos','tipo_factor_riesgo_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
