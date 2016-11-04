<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organo extends Model
{
     use SoftDeletes;
       
	protected $table = 'organos';

	protected $fillable = [
        'descripcion','tipo_organo_id'
    ];
    
    protected $dates = ['deleted_at'];


    public function exploraciones()
    {
        return $this->hasMany('App\Exploracion','organo_id');
    }

     public function tipo_organo()
    {
        return $this->belongsTo('App\Tipo_organo','tipo_organo_id');
    }
}
