<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Citas;
use App\User;
class CitasController extends Controller
{
    public function index()
    {

        
        $pacientes=User::join('user_role','users.id','user_role.user_id')->where('role_id',4)->pluck('primernombre', 'users.id');
        //$paciente_list=['pacientes'=> $pacientes];
        return view('citas.index')->with(['pacientes' => $pacientes]);
       //return $data;
       }
    public function create(){
        $title = $_POST['title'];
        $start = $_POST['start'];
        
        $evento = new Citas;
        $evento -> fechainicio = $start;
        $evento -> descripcion = $title;
        
        $evento->save();
        
    }

}
