<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Crypt;
use App\User;
use App\Medico;
use App\Asistente;
use App\Historia_ocupacional;
use Carbon\Carbon;
use App\Paciente;
use App\Medico_paciente;
use Auth;


class HistoriasController extends Controller
{
    /**
     * .
     * Muestra los pacientes del sistema para la carga de historias
     * @param  $request->search  para filtro de resultado
     */
    public function index(Request $request)
    {
        $users=User::ofType($request->search)->has('paciente')->orderby('numerodocumento','ASC')->paginate(15);
        $role = User::find(Auth::user()->id)->roles()->pluck('descripcion');

        if($role->contains('administrador')){
          
            $querymedicos=User::has('medico')->with('medico');
            if($querymedicos->count()==0){

                flash('No existen médicos registrados en el sistema!', 'danger');
                return redirect()->route('home');
               
            }elseif($querymedicos->count()==1){

                $medicos=$querymedicos->first()->medico->id;

            }else{
                
                foreach ($querymedicos->get() as $medico) {
                    $medicos[$medico->medico->id]=$medico->tipodocumento.' '.$medico->numerodocumento.' '.$medico->primerapellido.' '.$medico->primernombre;
                }
            }
        }elseif($role->contains('medico')){
            $medico=Medico::has('user')->where('user_id',Auth::user()->id)->first();
            $medicos=$medico->id;

        }elseif($role->contains('asistente')){

            $Asistente=Asistente::where(['user_id'=>Auth::user()->id])->first();
            $querymedicos = Asistente::find($Asistente->id)->medicos();
            if($querymedicos->count()==0){
                flash('No estas asignado(a) a ningún médico dentro del sistema!', 'danger');
                return redirect()->route('home');

            }elseif($querymedicos->count()==1){
                $medicos=$querymedicos->first()->id;
              
            }else{
                foreach ($querymedicos->with('user')->get() as $medico) {
                    $medicos[$medico->id]=$medico->user->tipodocumento.' '.$medico->user->numerodocumento
                    .' '.$medico->user->primerapellido.' '.$medico->user->primernombre;
                }
            }
         
        }else{
            flash('No tiene permiso de entrar a esta área, por favor contacte al administrador!', 'danger');
            return redirect()->route('home');
        }
         
        return  view('historias.index')->with(['users'=>$users,'medicos'=>$medicos ]);
    }

   

    /**
     * .
     * Verifica y redirecciona a la historia en la que se trabajaá
     * @param  $paciente_id,$especialidad_id (Ocupacional | Pediatría | Ginecología ),$medico_id
     */
    public function historia($paciente_id,$especialidad_id,$medico_id)
    {
        if($especialidad_id=='ocupacional'){
             $especialidad_id=1;
        }elseif($especialidad_id=='ginecologica'){
            $especialidad_id=3;
        }elseif($especialidad_id=='pediatria'){
            $especialidad_id=2;
        }
        $medico_paciente = Medico_paciente::where(['paciente_id' => $paciente_id,'especialidad_id' => $especialidad_id,'medico_id' => $medico_id] )->first();
        if(is_null($medico_paciente)){

            $medico_paciente= new Medico_paciente;
            $medico_paciente->paciente()->associate($paciente_id);
            $medico_paciente->medico()->associate($medico_id);
            $medico_paciente->especialidad_id=$especialidad_id;
            $medico_paciente->save();
        }

        if($especialidad_id==1){
            
            return redirect()->route('historias.ocupacional.index', ['paciente_id' => $medico_paciente->paciente_id,'medico_paciente_id' => $medico_paciente->id]);

        }elseif($especialidad_id==3){
            return redirect()->route('historias.ginecologica.index', ['paciente_id' => $medico_paciente->paciente_id,'medico_paciente_id' => $medico_paciente->id]);

        }elseif($especialidad_id==2){

            echo "Pediatria";
        }

    }
      
        
}
