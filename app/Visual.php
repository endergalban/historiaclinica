<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visual extends Model
{
    use SoftDeletes;

    protected $table = 'visuales';

	protected $fillable = [
        'historia_ocupacional_id','descripcion','examen_visual_id'
    ];

    protected $dates = ['deleted_at'];

    public function historia_ocupacional()
    {
        return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
    }

    public function examen_visual()
    {
        return $this->belongsTo('App\Examen_visual','examen_visual_id');
    }


   
}
