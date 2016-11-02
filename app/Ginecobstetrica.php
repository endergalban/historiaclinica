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

    protected $dates = ['deleted_at'];

	public function historia_ocupacional(){
		return $this->belongsTo('App\historia_ocupacional','historia_ocupacional_id');
	}

	
}
