<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_diagnostico extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_diagnosticos';

	protected $fillable = [
        'descripcion','codigo',
    ];

    protected $dates = ['deleted_at'];

    public function diagnosticos()
    {
        return $this->hasMany('App\Diagnostico','tipo_diagnostico_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%')->orWhere('codigo', 'like' , '%'.$type.'%');
    }
}
