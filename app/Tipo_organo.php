<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_organo extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_organos';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function organos()
    {
        return $this->hasMany('App\Organos','tipo_organo_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
