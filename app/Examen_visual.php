<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examen_visual extends Model
{
     use SoftDeletes;

    protected $table = 'examen_visuales';

	protected $fillable = [
        'tipo_examen_id','ojo_id',
    ];

    protected $dates = ['deleted_at'];

    public function tipo_examen_visuales()
    {
        return $this->belongsTo('App\Tipo_examen_visual','tipo_examen_visual_id');
    }

    public function ojos()
    {
        return $this->belongsTo('App\Ojo','ojo_id');
    }
}
