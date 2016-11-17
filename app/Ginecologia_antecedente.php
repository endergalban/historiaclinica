<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ginecologia_antecedente extends Model
{
    use SoftDeletes;
	
    protected $table='ginecologia_antecedentes';

    protected $fillable = [
		'historia_ginecologica_id', 'alergias', 'ingresos', 'traumatismos', 'tratamientos', 'hta', 'displidemia', 'dm', 'otros', 'habitos', 'familiares',
		]
	protected $dates = ['deleted_at'];

	public function historia_ginecologica()
    {
        return $this->belongsTo('App\Historia_ginecologica','historia_ginecologica_id');
    }
}
