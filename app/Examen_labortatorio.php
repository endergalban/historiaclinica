<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Examen_labortatorio extends Model
{
    use SoftDeletes;

    protected $table = 'examen_laboratorios';

    protected $fillable = [
        'historia_ocupacional_id','examen','fecha','resultado',
    ];

    protected $dates = ['deleted_at','fecha'];

	public function historia_ocupacional(){
		return $this->belonsTo('App\Historia_ocupacional','historia_ocupacional_id');
	}

}
