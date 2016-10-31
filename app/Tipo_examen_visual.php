<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_examen_visual extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_examenes';

	protected $fillable = [
        'ojo_id','descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function ojos()
    {
        return $this->belongsTo('App\Ojo','ojo_id');
    }

    
}
