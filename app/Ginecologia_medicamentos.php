<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_medicamentos extends Model
{
     use SoftDeletes;
	
    protected $table='ginecologia_medicamentos';

    protected $fillable = [
		'historia_ginecologica_id','descripcion','dosis',
	];

	protected $dates = ['deleted_at'];

	public function historia_ginecologica()
    {
        return $this->belongsTo('App\Historia_ginecologica','historia_ginecologica_id');
    }
}
