<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_incapacidad extends Model
{
    use SoftDeletes;
	
    protected $table='ginecologia_incapacidades';

    protected $fillable = [
		'historia_ginecologica_id','fechainicial','fechafinal','observacion',
	];

	protected $dates = ['deleted_at','fechainicial','fechafinal'];

	public function historia_ginecologica()
    {
        return $this->belongsTo('App\Historia_ginecologica','historia_ginecologica_id');
    }

}
