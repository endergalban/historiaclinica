<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesion extends Model
{
    use SoftDeletes;

    protected $table = 'lesiones';

	protected $fillable = [
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    public function traumatologicos()
    {
        return $this->hasMany('App\Traumatologico','lesion_id');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('descripcion', 'like' , '%'.$type.'%');
    }
}
