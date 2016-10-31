<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Traumatologico extends Model
{
     use SoftDeletes;

    protected $table = 'traumatologicos';

	protected $fillable = [
        'antecedente_ocupacional_id','lesion_id','secuelas','otros','arl',
    ];

    protected $dates = ['deleted_at'];

    public function antecedente_ocupacional()
    {
        return $this->belongsTo('App\Antecedente_ocupacional','antecedente_ocupacional_id');
    }

    public function lesiones()
    {
        return $this->belongsTo('App\Lesion','lesion_id');
    }

}
