<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Asistente;
use Illuminate\Support\Facades\Auth;

class EscritorioController extends Controller
{
	/**
     * .
     * Determina que tipo de usuario es
     * 
     */
    public function verificar_usuario(){
    	$role = User::find(Auth::user()->id)->roles()->pluck('descripcion');
    	if($role->contains('administrador')){ 
    		//
    	}

    	if($role->contains('medico')){ 
    		//
    	}

    	if($role->contains('asistente')){ 
    		if($role->count()==1){  //SI SOLO ES ASISTENTE
	            $medico=Asistente::where(['user_id'=>Auth::user()->id])->wherehas('medicos')->first(); //VERIFICO SI TIENE MÉDICOS

	            if(is_null($medico)){
	               
	                Auth::logout();
                    flash('El usuario asistente no tiene médicos asignados!', 'danger');
	                return redirect('/login');
	            }
        	}
    	}

    	if($role->contains('paciente')){
    		// 
    	}
            
		return view('home');

    }
}
