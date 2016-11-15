<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consentimiento extends Model
{
     use SoftDeletes;
	
    protected $table = 'consentimientos';

	protected $fillable = [
        'otro','tipo_consentimiento_id','historia_ocupacional_id',
    ];
    
    protected $dates = ['deleted_at'];

  	public function historia_ocupacional()
    {
        return $this->belongsTo('App\Historia_ocupacional','historia_ocupacional_id');
    }

    public function tipo_consentimiento()
    {
        return $this->belongsTo('App\Tipo_consentimiento','tipo_consentimiento_id');
    }

}
