<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Citas;
use App\Paciente;

class CitasController extends Controller
{
    public function index()
    {

        
        $querypacientes=Paciente::with('user')->get();
        $pacientes = array();
        foreach ($querypacientes as $paciente) {
            $pacientes[$paciente->id]=$paciente->user->numerodocumento.' - '.$paciente->user->primernombre.' '.$paciente->user->primerapellido;
        }
       return view('citas.index')->with(['pacientes' => $pacientes]);
       }
    public function create(){

        $title = $_POST['title'];
        $start = $_POST['start'];
        $duracion = $_POST['duracion'];
        $color = $_POST['color'];
        $id_paciente = $_POST['id_paciente'];
        
        //$date = date_create($start);
        $date = date_create_from_format('d/m/Y H:i A',$start);

        $evento = new Citas;
        $evento -> fechainicio =$date->format('Y-m-d H:i:s');
        $evento -> fechafin = $date->modify("+{$duracion} minutes");
        $evento -> descripcion = $title;
        $evento -> color = $color;
        $evento -> medico_paciente_id = $id_paciente;
        
        $evento->save();
        
    }

    public function api()
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
               // echo $start;
        //return;
        $citas = array();
        $id = Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->pluck('id');
        $titulo = Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->pluck('descripcion');
        $fechainicio = Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->pluck('fechainicio');
        $fechafin = Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->pluck('fechafin');
        $color= Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->pluck('color');
        $id_pa= Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->pluck('medico_paciente_id');
        $count = count($id);
        $interval = $fechainicio->diff($fechafin);
        for ($i=0 ; $i< $count; $i++){
            $citas[$i]= array(
                'title' => $titulo[$i],
                'start' => $fechainicio[$i],
                'end' => $fechafin[$i],
                'allDay' => false,
                'backgroundColor' => $color[$i],
                'borderColor'=> $color[$i],
                'id' => $id[$i],
                'id_pa' => $id_pa[$i],
                'diff' => $interval
            );    

        }  
        json_encode($citas);
        return $citas;
    }

}
