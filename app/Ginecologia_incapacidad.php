<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_incapacidad extends Model
{
    use SoftDeletes;
	
    protected $table='ginecologia_incapacidades';

    protected $fillable = [
		'historia_ginecologica_id','fachainical','fechafinal','observacion',
	]

	protected $dates = ['deleted_at','fachainical','fechafinal'];

	public function historia_ginecologica()
    {
        return $this->belongsTo('App\Historia_ginecologica','historia_ginecologica_id');
    }

}
