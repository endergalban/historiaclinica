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

    public function medico($paciente_id)
    {
        $paciente=Paciente::has('user')->where(['id'=>$paciente_id])->with('user')->first();
        $role = User::find(Auth::user()->id)->roles()->pluck('descripcion');
        if($role->contains('administrador')){ //USUARIO ADMINISTRADOR
          
            $medicos=User::has('medico')->with('medico.especialidades')->get();
            if($medicos->count()==0){
                flash('No existen médicos registrados en el sistema!', 'danger');
                return redirect()->route('historias.index'  );
            }else{
                return  view('historias.medicos')->with(['medicos'=>$medicos,'paciente'=>$paciente]);
            }


        }elseif($role->contains('medico')){ //USUARIO MEDICO
            $medico=User::has('medico')->where('id',Auth::user()->id)->with('medico.especialidades')->first();
           
            if($medico->medico->especialidades->count() == 0){ //SIN ESPECIALIDAD
                flash('No existen especialidades registrados a tu usuario, comuniquese con el administrador!', 'danger');
                return redirect()->route('historias.index');
            }elseif($medico->medico->especialidades->count() == 1){ //UNA ESPECIALIDAD
                 
               if($medico->medico->especialidades->first()->id==3){ //GINECOLOGIA
                    
                    if($paciente->user->genero=='Masculino') { // SI ES MASCULINO NO PODRA ABRIR LA HISTORIA GINECOLOGIA
                        flash('Tu especialidad solo es Ginecología, no puedes cargar la historia a una persona del genero masculino!', 'danger');
                        return redirect()->route('historias.index');
                    }else{ // REDIRECCIONO SI NO ES MASCULINO PARA ABRIR LA HISTORIA GINECOLOGIA
                        return redirect()->route('historias.historia',[$paciente_id,$medico->medico->especialidades->first()->id,$medico->medico->id]);
                    }
                }else{ //NO GINECOLOGIA 

                    return redirect()->route('historias.historia',[$paciente_id,$medico->medico->especialidades->first()->id,$medico->medico->id]);
                }
            }elseif($medico->medico->especialidades->count() == 2){  //DOS ESPECIALIDADES
               
                if($medico->medico->especialidades->contains('3')) // CONTIENE GINECOLOGIA
                {
                     if($paciente->user->genero=='Masculino') { //REDIRECCIONO A LA QUE NO ES GINECOLOGIA
                           
                        return redirect()->route('historias.historia',[$paciente_id, $medico->medico->especialidades->except([3])->first()->id,$medico->medico->id]);
                     }else{ //MUESTRO LA PAGINA PARA QUE MEDICO ESCOJA LA ESPECIALIDAD
                        $medicos[]=$medico;
                        return  view('historias.medicos')->with(['medicos'=>$medicos,'paciente'=>$paciente]);
                     }

                }else{ //NO CONTIENE GINECOLOGIA MUESTRO LA PAGINA PARA QUE MEDICO ESCOJA LA ESPECIALIDAD
                    $medicos[]=$medico;
                    return  view('historias.medicos')->with(['medicos'=>$medicos,'paciente'=>$paciente]);       
                }   
            }else{ // MAS DE DOS ESPECIALIDADES MUESTRO LA PAGINA PARA QUE MEDICO ESCOJA LA ESPECIALIDAD
                
                $medicos[]=$medico;
                return  view('historias.medicos')->with(['medicos'=>$medicos,'paciente'=>$paciente]);   

            }

        }elseif($role->contains('asistente')){ //USUARIO ASISTENTE

            $Asistente=Asistente::where(['user_id'=>Auth::user()->id])->first();
            $asistente_id = $Asistente->id;
            $medico = User::wherehas('medico.asistentes',function ($query) use ($asistente_id){
                $query->where([ 'asistente_id' => $asistente_id]);
            })->with('medico.especialidades')->get();
            if($medico->count()==0){
                flash('No estas asignado(a) a ningún médico dentro del sistema!', 'danger');
                 return redirect()->route('historias.index');

            }elseif($medico->count()==1){
                $medico=$medico->first();
                if($medico->medico->especialidades->count() == 0){ //SIN ESPECIALIDAD

                    flash('El médico asignado no posee especialidades registradas, comuniquese con el administrador!', 'danger');
                    return redirect()->route('historias.index');

                }elseif($medico->medico->especialidades->count() == 1){ //UNA ESPECIALIDAD
                 
                   if($medico->medico->especialidades->first()->id==3){ //GINECOLOGIA
                        
                        if($paciente->user->genero=='Masculino') { // SI ES MASCULINO NO PODRA ABRIR LA HISTORIA GINECOLOGIA
                            flash('La especialidad del médico es Ginecología, no puedes cargar la historia a una persona del genero masculino!', 'danger');
                            return redirect()->route('historias.index');
                        }else{ // REDIRECCIONO SI NO ES MASCULINO PARA ABRIR LA HISTORIA GINECOLOGIA
                            return redirect()->route('historias.historia',[$paciente_id,$medico->medico->especialidades->first()->id,$medico->medico->id]);
                        }
                    }else{ //NO GINECOLOGIA 

                        return redirect()->route('historias.historia',[$paciente_id,$medico->medico->especialidades->first()->id,$medico->medico->id]);
                    }
                }elseif($medico->medico->especialidades->count() == 2){  //DOS ESPECIALIDADES
                   
                    if($medico->medico->especialidades->contains('3')) // CONTIENE GINECOLOGIA
                    {
                         if($paciente->user->genero=='Masculino') { //REDIRECCIONO A LA QUE NO ES GINECOLOGIA
                               
                            return redirect()->route('historias.historia',[$paciente_id, $medico->medico->especialidades->except([3])->first()->id,$medico->medico->id]);
                         }else{ //MUESTRO LA PAGINA PARA QUE MEDICO ESCOJA LA ESPECIALIDAD
                            $medicos[]=$medico;
                            return  view('historias.medicos')->with(['medicos'=>$medicos,'paciente'=>$paciente]);
                         }

                    }else{ //NO CONTIENE GINECOLOGIA MUESTRO LA PAGINA PARA QUE MEDICO ESCOJA LA ESPECIALIDAD
                        $medicos[]=$medico;
                        return  view('historias.medicos')->with(['medicos'=>$medicos,'paciente'=>$paciente]);       
                    }   
                }else{ // MAS DE DOS ESPECIALIDADES MUESTRO LA PAGINA PARA QUE MEDICO ESCOJA LA ESPECIALIDAD
                    
                    $medicos[]=$medico;
                    return  view('historias.medicos')->with(['medicos'=>$medicos,'paciente'=>$paciente]);   

                }
             
            }else{
                return  view('historias.medicos')->with(['medicos'=>$medico,'paciente'=>$paciente]); 
            }
         
        }else{
            flash('No tiene permiso de entrar a esta área, por favor contacte al administrador!', 'danger');
            abort(404);
        }

    }

    /**
     * .
     * Muestra los pacientes
     * @param  $request->search para los pacientes
     */
    public function index(Request $request)
    {
        $role = User::find(Auth::user()->id)->roles()->pluck('descripcion');
        if($role->contains('administrador')){ //USUARIO ADMINISTRADOR

            $users=User::ofType($request->search)->has('paciente.medico_pacientes.medico.user')->orderby('numerodocumento','ASC')->paginate(15);
     
        }elseif($role->contains('medico')){ //USUARIO MEDICO

            $Medico=Medico::where(['user_id'=>Auth::user()->id])->first();
            $medico_id = $Medico->id;
            $users = User::ofType($request->search)->wherehas('paciente.medico_pacientes',function ($query) use ($medico_id){
                $query->where([ 'medico_id' => $medico_id]);
            })->with(['paciente.medico_pacientes' => function ($query) use ($medico_id){
                $query->where([ 'medico_id' => $medico_id]);
            }])->orderby('numerodocumento','ASC')->paginate(15);
     

        }elseif($role->contains('asistente')){ //USUARIO ASISTENTE

            $asistente_id=Asistente::where(['user_id'=>Auth::user()->id])->first()->id;
            $Medicos=Medico::whereHas('asistentes',function($query) use ($asistente_id){
                $query->where([ 'asistente_id' => $asistente_id]);
            })->pluck('id');
           
            $users = User::ofType($request->search)->wherehas('paciente.medico_pacientes',function ($query) use ($Medicos){
                $query->whereIn( 'medico_id' , $Medicos);
            })->with(['paciente.medico_pacientes' => function ($query) use ($Medicos){
                $query->whereIn('medico_id', $Medicos );
            }])->orderby('numerodocumento','ASC')->paginate(15);
        }

        if(Auth::user()->roles()->get()->whereIn('id',[1,2])->count()==0)
        {$acciones=false;}else{$acciones=true;}     
        
        return  view('historias.index')->with(['users'=>$users,'acciones'=>$acciones]);  
    }

      /**
     * .
     * Muestra las historias eliminadas
     * @param  $request->search para los pacientes
     */
    public function reciclaje(Request $request)
    {
        $role = User::find(Auth::user()->id)->roles()->pluck('descripcion');
        if($role->contains('administrador')){ //USUARIO ADMINISTRADOR

            $Medico_paciente=Medico_paciente::onlyTrashed()->with('paciente.user')->with('medico.user')->with('especialidad')->get();
    
        }elseif($role->contains('medico')){ //USUARIO MEDICO
            $medico_id=Medico::where('user_id',Auth::user()->id)->first()->id;
            $Medico_paciente=Medico_paciente::onlyTrashed()->where('medico_id',$medico_id)->with('paciente.user')->with('medico.user')->with('especialidad')->get();
          

        }elseif($role->contains('asistente')){ //USUARIO ASISTENTE
            
            $asistente_id=Asistente::where(['user_id'=>Auth::user()->id])->first()->id;
            $Medicos=Medico::whereHas('asistentes',function($query) use ($asistente_id){
                $query->where([ 'asistente_id' => $asistente_id]);
            })->pluck('id');

            $Medico_paciente=Medico_paciente::onlyTrashed()->whereIn('medico_id',$Medicos)->with('paciente.user')->with('medico.user')->with('especialidad')->get();
        }
         return  view('historias.reciclaje')->with(['Medico_pacientes' => $Medico_paciente]); 
    }


       /**
     * .
     * Muestra las historias eliminadas
     * @param  $request->search para los pacientes
     */
    public function restaurar($medico_paciente_id)
    {
        $Medico_paciente = Medico_paciente::onlyTrashed()->findOrFail($medico_paciente_id);
        $Medico_paciente->restore();
        flash('Las historias se han restaurado de forma exitosa!', 'success');
        return redirect()->route('historias.index');
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
        $medico_paciente = Medico_paciente::withTrashed()->where(['paciente_id' => $paciente_id,'especialidad_id' => $especialidad_id,'medico_id' => $medico_id] )->first();
        if(is_null($medico_paciente)){

            $medico_paciente= new Medico_paciente;
            $medico_paciente->paciente()->associate($paciente_id);
            $medico_paciente->medico()->associate($medico_id);
            $medico_paciente->especialidad_id=$especialidad_id;
            $medico_paciente->save();
        }else{
            if ($medico_paciente->trashed()) {
                $medico_paciente->restore();
            }
        }

        if($especialidad_id==1){
            
            return redirect()->route('historias.ocupacional.index', ['paciente_id' => $medico_paciente->paciente_id,'medico_paciente_id' => $medico_paciente->id]);

        }elseif($especialidad_id==3){
            return redirect()->route('historias.ginecologica.index', ['paciente_id' => $medico_paciente->paciente_id,'medico_paciente_id' => $medico_paciente->id]);

        }elseif($especialidad_id==2){

            echo "Pediatria";
        }

    }


    /**
     * .
     * Elimina el vinculo entre médico y paciente
     * @param  $paciente_id,$especialidad_id (Ocupacional | Pediatría | Ginecología ),$medico_id
     */
    public function destroy($medico_paciente_id)
    {
        $Medico_paciente=Medico_paciente::find($medico_paciente_id);
        $Medico_paciente->delete();
        flash('Se ha eliminado la historia de   forma exitosa!', 'danger');
        return redirect()->route('historias.index');
    }
      
        
}
