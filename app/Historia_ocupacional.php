<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historia_ocupacional extends Model
{
     use SoftDeletes;
	
    protected $table='historia_ocupacionales';

    protected $fillable = [
        'medico_paciente_id','escolaridad_id','tipo_examen_id','numerohijos','numeropersonascargo','arl_id','afp_id','empresa_id','empresa',
    ];

    protected $dates = ['deleted_at'];

    public function examen_fisico()
    {
        return $this->hasOne('App\Examen_fisico','historia_ocupacional_id');
    }

    public function ocupacional_actual()
    {
        return $this->hasOne('App\Ocupacional_actual','historia_ocupacional_id');
    }

    public function medico_paciente()
    {
        return $this->belongsTo('App\Medico_paciente','medico_paciente_id');
    }

    public function escolaridad()
    {
        return $this->belongsTo('App\Escolaridad','escolaridad_id');
    }

    public function tipo_examen()
    {
        return $this->belongsTo('App\Tipo_examen','tipo_examen_id');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Empresa','empresa_id');
    }

    public function arl()
    {
        return $this->belongsTo('App\Arl','arl_id');
    }

    public function afp()
    {
        return $this->belongsTo('App\Afp','afp_id');
    }

    public function antecedente_ocupacionales()
    {
        return $this->hasMany('App\Antecedente_ocupacional','historia_ocupacional_id');
    }

    public function patologicos()
    {
        return $this->hasMany('App\Patologico','historia_ocupacional_id');
    }

    public function habito_fumadores()
    {
        return $this->hasMany('App\Habito_fumador','historia_ocupacional_id');
    }

    public function habito_licores()
    {
        return $this->hasMany('App\Habito_licor','historia_ocupacional_id');
    }

    public function habito_medicamentos()
    {
        return $this->hasMany('App\Habito_medicamento','historia_ocupacional_id');
    }

    public function inmunizaciones()
    {
        return $this->hasMany('App\Inmunizacion','historia_ocupacional_id');
    }

    public function ginecobstetricas()
    {
        return $this->hasMany('App\Ginecobstetrica','historia_ocupacional_id');
    }

    public function exploraciones()
    {
        return $this->hasMany('App\Exploracion','historia_ocupacional_id');
    }

    public function visuales()
    {
        return $this->hasMany('App\Visual','historia_ocupacional_id');
    }

    public function examen_laboratorios()
    {
        return $this->hasMany('App\Examen_laboratorio','historia_ocupacional_id');
    }

    public function diagnosticos()
    {
        return $this->belongsToMany('App\Factor_riesgo','historia_ocupacional_diagnostico','historia_ocupacional_id','diagnostico_id');
    }
}
