<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_consentimiento extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_consentimientos';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function consentimientos()
    {
        return $this->hasMany('App\Consentimiento','tipo_consentimiento_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
