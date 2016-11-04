<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecobstetrica extends Model
{
	use SoftDeletes;

    protected $table = 'ginecobstetricas';

    protected $fillable = [
        'historia_ocupacional_id','fum','fuc','citologia','gravidez','partos','abortos','cesarias',
    ];

    protected $dates = ['deleted_at','fum','fuc'];

	public function historia_ocupacional(){
		return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
	}

	
}
