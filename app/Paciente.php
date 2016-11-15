<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use SoftDeletes;
    
  	protected $table = 'pacientes';

  	protected $fillable = [
  		'user_id','empresa_id','arl_id','afp_id',
  	];

    protected $dates = ['deleted_at'];
   	
   	public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

     public function afp()
    {
        return $this->belongsTo('App\Afp');
    }

     public function arl()
    {
        return $this->belongsTo('App\Arl');
    }
    public function medico_pacientes(){
         return $this->hasMany('App\Medico_paciente','paciente_id');
    }

    public function municipio()
    {
        return $this->belongsTo('App\Municipio');
    }


    public function scopeOfType($query, $type){
        
        return $query->where('numerodocumento', 'like' , '%'.$type.'%')->orwhere('primernombre', 'like' , '%'.$type.'%')->orwhere('primerapellido', 'like' , '%'.$type.'%');
    }
}
