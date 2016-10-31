<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regularidad_medicamento extends Model
{
    use SoftDeletes;
       
	protected $table = 'regularidad_medicamentos';

	protected $fillable = [
        'descripcion',
    ];
    
    protected $dates = ['deleted_at'];


    public function habito_medicamentos()
    {
        return $this->hasMany('App\Habito_medicamento','regularidad_medicamento_id');
    }
}
