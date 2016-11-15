<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;



class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    


    protected $fillable = [
         'email', 'password','tipodocumento', 'numerodocumento', 'primernombre', 'segundonombre', 'primerapellido', 'segundoapellido', 'fechanacimiento','genero', 'estadocivil', 'pais', 'departamento', 'municipio_id','direccion', 'ocupación', 'telefono','activo','firma','imagen','create_at',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = [
        'fechanacimiento','deleted_at','create_at'
    ];

  /* public function setFechanacimientoAttribute($value)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('d/m/Y', $value);
    }
*/


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function municipio()
    {
        return $this->belongsTo('App\Municipio');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role','user_role','user_id','role_id');
    }

    public function medico()
    {
        return $this->hasOne('App\Medico');
    }

    public function asistente()
    {
        return $this->hasOne('App\Asistente');
    }

    public function paciente()
    {
        return $this->hasOne('App\Paciente');
    }

    public function scopeOfType($query, $type){
        
        return $query->where('numerodocumento', 'like' , '%'.$type.'%')->orwhere('primernombre', 'like' , '%'.$type.'%')->orwhere('primerapellido', 'like' , '%'.$type.'%');
    }

     public function modulos(){

        $query= DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->join('role_modulo', 'roles.id', '=', 'role_modulo.role_id')
            ->join('modulos', 'role_modulo.modulo_id', '=', 'modulos.id');
        return $query;
    }

    public function menu($id){

        $result = $this->modulos()->select('modulos.orden as orden','modulos.icono as icono','modulos.descripcion as descripcion','modulos.site as site')->where(['users.id' => $id,'modulos.visible' => 1])->orderBy('orden', 'asc')->groupBy(['modulos.id','modulos.orden','modulos.icono','modulos.descripcion','modulos.site'])->get();
        return $result;
    }

    public function validar($site,$id){

        $result = $this->modulos()->where('users.id', $id)->where('modulos.site', $site)->count();
        if($result>0){ return true;}
        return false;
    }

    public function hasAnyRole($roles){

        if(is_array($roles))
        {
             if($this->roles()->whereIn('descripcion', $roles)->first())
             {
                return true;
             }
            
        }else{
            if($this->roles()->where('descripcion', $roles)->first())
            {
                return true;
            }
        }
        return false;
    }

  
}
