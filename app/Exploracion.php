<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exploracion extends Model
{
    use SoftDeletes;

    protected $table = 'exploraciones';

    protected $fillable = [
        'historia_ocupacional_id','id_organo','resultado',
    ];

    protected $dates = ['deleted_at'];

	public function historia_ocupacional(){
		return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
	}

	public function organo(){
		return $this->belongsTo('App\Organo','organo_id');
	}
}
