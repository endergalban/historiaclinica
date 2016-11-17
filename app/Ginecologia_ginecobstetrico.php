<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_ginecobstetrico extends Model
{
    use SoftDeletes;
	
    protected $table='ginecologia_ginecobstetricos';

    protected $fillable = [
		'historia_ginecologica_id','gestante', 'fum', 'seguridad', 'cesareas', 'partos', 'abortos', 'gestaciones', 'fpp',
		 ]
	protected $dates = ['deleted_at','fum','fpp'];

	public function historia_ginecologica()
    {
        return $this->belongsTo('App\Historia_ginecologica','historia_ginecologica_id');
    }
}
