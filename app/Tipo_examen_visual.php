<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_examen_visual extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_examen_visuales';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function examen_visuales()
    {
        return $this->hasMany('App\Examen_visual','tipo_examen_visual_id');
    }

    
}
