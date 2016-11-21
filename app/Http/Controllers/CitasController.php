<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Citas;
use App\User;
use App\Paciente;
use App\Medico;
use App\Especialidad;
use App\Medico_paciente;
use App\Asistente;
use Auth;

class CitasController extends Controller
{
    public function index(Request $request)
    {

        
        $querypacientes=Paciente::has('user')->with('user')->get();
        $pacientes = array();
        foreach ($querypacientes as $paciente) {
            $pacientes[$paciente->id]=$paciente->user->numerodocumento.' - '.$paciente->user->primernombre.' '.$paciente->user->primerapellido;
        }
        $users=User::ofType($request->search)->has('paciente')->orderby('numerodocumento','ASC')->paginate(15);
        $role = User::find(Auth::user()->id)->roles()->pluck('descripcion');
        $medicos=array();
        if($role->contains('administrador')){
           
            $query_medicos=User::has('medico')->with('medico.especialidades')->get();

        }elseif($role->contains('medico')){
           
           $query_medicos=User::has('medico')->where('id',Auth::user()->id)->with('medico.especialidades')->get(); 

        }elseif($role->contains('asistente')){
            $Asistente=Asistente::where(['user_id'=>Auth::user()->id])->first();
            $asistente_id = $Asistente->id;
            $query_medicos = User::wherehas('medico.asistentes',function ($query) use ($asistente_id){
                $query->where([ 'asistente_id' => $asistente_id]);
            })->with('medico.especialidades')->get();
         
        }else{
            flash('No tiene permiso de entrar a esta área, por favor contacte al administrador!', 'danger');
            return redirect()->route('home');
        }
        $medicos=array();
        $medicos[0]='Seleccione el Médico';

        foreach ($query_medicos as $medico ) {
            
            $medicos[$medico->medico->id]=$medico->primernombre.' '.$medico->primerapellido;

        }
        
         $especialidades[0]='Seleccione la Especialidad';
       
        return view('citas.index')->with(['pacientes' => $pacientes, 'users'=>$users,'medicos'=>$medicos,'especialidades'=>$especialidades]);
   }

    public function create(){

        $title = $_POST['title'];
        $start = $_POST['start'];
        $duracion = $_POST['duracion'];
        $color = $_POST['color'];
        $id_paciente = $_POST['id_paciente'];
        $id_medico=$_POST['id_medico'];
        $id_especialidad=$_POST['id_especialidad'];


         $medico_paciente = Medico_paciente::where(['paciente_id' => $id_paciente,'especialidad_id' => $id_especialidad,'medico_id' => $id_medico] )->first();

        //$paciente = Paciente::where(['id'=>$paciente_id])->with('user')->first();
        //$medico = Medico::where(['id'=> $medico_id])->with('user')->first();

        if(is_null($medico_paciente)){

            $medico_paciente= new Medico_paciente;
            $medico_paciente->paciente()->associate($id_paciente);
            $medico_paciente->medico()->associate($id_medico);
            $medico_paciente->especialidad_id=$id_especialidad;
            $medico_paciente->save();
        }

        //$date = date_create($start);
        $date = date_create_from_format('d/m/Y H:i A',$start);

        $evento = new Citas;
        $evento -> fechainicio =$date->format('Y-m-d H:i:s');
        $evento -> fechafin = $date->modify("+{$duracion} minutes");
        $evento -> descripcion = $title;
        $evento -> color = $color;
        $evento -> medico_paciente_id = $medico_paciente->id;
        
        $evento->save();
        
    }
    public function borrar()
    {
        $id = $_POST['id_cita'];

        $cita = Citas::find($id);
        $cita -> delete();

    }
    public function api()
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $id_medico = $_GET['medico_id'];
        $id_especialidad = $_GET['especialidad_id'];

        $medico_paciente = Medico_paciente::where(['especialidad_id' => $id_especialidad,'medico_id' => $id_medico] )->get();
        $array_medico_paciente = array();
        foreach ($medico_paciente  as $med_pac) {
            $array_medico_paciente[] = [
                'medico_paciente_id' => $med_pac->id
            ]; 
        }

        //$paciente = Paciente::where(['id'=>$paciente_id])->with('user')->first();
        //$medico = Medico::where(['id'=> $medico_id])->with('user')->first();

        //$medico_paciente = Medico_paciente::where(['especialidad_id' => $especialidad_id,'medico_id' => $medico_id] )->first();
               // echo $start;
        //return;
        //if ()
       
        $citas = array();
        $id = Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->whereIn('medico_paciente_id',$array_medico_paciente)->pluck('id');
        $titulo = Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->whereIn('medico_paciente_id',$array_medico_paciente)->pluck('descripcion');
        $fechainicio = Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->whereIn('medico_paciente_id',$array_medico_paciente)->pluck('fechainicio');
        $fechafin = Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->whereIn('medico_paciente_id',$array_medico_paciente)->pluck('fechafin');
        $color= Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->whereIn('medico_paciente_id',$array_medico_paciente)->pluck('color');
        //$id_pa= Citas::where('fechainicio','>=',$start)->where('fechafin','<=',$end)->whereIn('medico_paciente_id',$array_medico_paciente)->pluck('medico_paciente_id');
        //$id_pa = User::with('paciente.medico_pacientes.citas')->whereHas('citas',$array_medico_paciente);
        $id_pa = Citas::with('medico_pacientes.paciente')->where('fechainicio','>=',$start)->where('fechafin','<=',$end)->whereIn('medico_paciente_id',$array_medico_paciente)->get();

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
                'id_pa' => $id_pa[$i]->medico_pacientes->paciente->id,
                'diff' => $interval
            );    
        }  
        json_encode($citas);
        return $citas;
    }

}
