<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_ginecobstetrico extends Model
{
    use SoftDeletes;
	
    protected $table='ginecologia_ginecobstetricos';

    protected $fillable = [
		'medico_paciente_id','gestante', 'fum', 'seguridad', 'cesarias', 'partos', 'abortos', 'gestaciones', 'fpp', 'getante',
		 ];
	protected $dates = ['deleted_at','fum','fpp'];

	public function medico_paciente()
    {
        return $this->belongsTo('App\Medico_paciente','medico_paciente_id');
    }
}
