<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_exploracion extends Model
{
	use SoftDeletes;
	
    protected $table='historia_ginecologicas';

    protected $fillable = [
		'historia_ginecologica_id','peso','talla','imc','ta','fc','fr','otros','aspectogeneral',
	]

	protected $dates = ['deleted_at'];

	public function historia_ginecologica()
    {
        return $this->belongsTo('App\Historia_ginecologica','historia_ginecologica_id');
    }

}