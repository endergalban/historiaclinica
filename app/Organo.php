<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organo extends Model
{
     use SoftDeletes;
       
	protected $table = 'organos';

	protected $fillable = [
        'descripcion',
    ];
    
    protected $dates = ['deleted_at'];


    public function exploraciones()
    {
        return $this->hasMany('App\Exploracion','organo_id');
    }
}
