<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_diagnostico extends Model
{
	use SoftDeletes;
	
    protected $table='ginecologia_diagnosticos';

    protected $fillable = [
		'historia_ginecologica_id','tipo_diagnostico_id','concepto',
	];

	protected $dates = ['deleted_at'];

	public function historia_ginecologica()
    {
        return $this->belongsTo('App\Historia_ginecologica','historia_ginecologica_id');
    }

    public function tipo_diagnostico()
    {
        return $this->belongsTo('App\Tipo_diagnostico','tipo_diagnostico_id');
    }
}
