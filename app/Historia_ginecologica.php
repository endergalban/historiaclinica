<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historia_ginecologica extends Model
{
    use SoftDeletes;
	
    protected $table='historia_ginecologicas';

    protected $fillable = [
        'medico_paciente_id','motivo_consulta', 'enfermedad_actual', 'informe', 'analisis', 'procedimientos', 'recomendaciones', 
        ];
    protected $dates = ['deleted_at'];

    public function medico_paciente()
    {
        return $this->belongsTo('App\Medico_paciente','medico_paciente_id');
    }

    public function ginecologia_exploracion()
    {
        return $this->hasOne('App\Ginecologia_exploracion','historia_ginecologica_id');
    }

    public function ginecologia_diagnosticos()
    {
        return $this->hasMany('App\Ginecologia_diagnostico','historia_ginecologica_id');
    }

    public function ginecologia_incapacidad()
    {
        return $this->hasOne('App\Ginecologia_incapacidad','historia_ginecologica_id');
    }

    public function ginecologia_antecedente()
    {
        return $this->hasOne('App\Ginecologia_antecedente','historia_ginecologica_id');
    }

    public function ginecologia_ginecobstetrico()
    {
        return $this->hasOne('App\Ginecologia_exploracion','historia_ginecologica_id');
    }

    public function ginecologia_exploracion_inicial()
    {
        return $this->hasOne('App\Ginecologia_exploracion_inicial','historia_ginecologica_id');
    }

    public function ginecologia_exploracion_periodicas()
    {
        return $this->hasMany('App\Ginecologia_exploracion_periodica','historia_ginecologica_id');
    }
}
