<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_antecedente extends Model
{
    use SoftDeletes;
	
    protected $table='ginecologia_antecedentes';

    protected $fillable = [
		'medico_paciente_id', 'alergias', 'ingresos', 'traumatismos', 'tratamientos', 'hta', 'displidemia', 'dm', 'otros', 'habitos', 'familiares','situacion',
		];
	protected $dates = ['deleted_at'];

	public function medico_paciente()
    {
        return $this->belongsTo('App\Medico_paciente','medico_paciente_id');
    }
}
