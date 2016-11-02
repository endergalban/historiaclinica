<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use Image;
use App\User;
use App\Medico;
use App\Asistente;
use App\Historia_ocupacional;
use Carbon\Carbon;
use App\Paciente;
use App\Medico_paciente;
use App\Tipo_examen;
use Auth;

class HistoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $users=User::ofType($request->search)->has('paciente')->orderby('numerodocumento','ASC')->paginate(15);
         
        $medico=Medico::has('user')->where('user_id',Auth::user()->id)->first();
        $asistente=Asistente::has('user')->where('user_id',Auth::user()->id)->first();
        if($medico){

            $medicos=$medico->id;

        }elseif($asistente){
            
            $med=User::with('asistente.medicos.user')->where('id',Auth::user()->id)->first();
            foreach ($med->asistente->medicos as $medico) {
                $medicos[$medico->id]=$medico->user->tipodocumento.' '.$medico->user->numerodocumento
                .' '.$medico->user->primerapellido.' '.$medico->user->primernombre;
            }
         
        }else{
          
            $querymedicos=User::has('medico')->orderby('tipodocumento','ASC')->get();
            foreach ($querymedicos as $medico) {
                $medicos[$medico->medico->id]=$medico->tipodocumento.' '.$medico->numerodocumento.' '.$medico->primerapellido.' '.$medico->primernombre;
            }
        }
         
        return  view('historias.index')->with(['users'=>$users,'medicos'=>$medicos ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::with('municipio.departamento.pais')->with('paciente')->where('id',$id)->first();
        return  view('historias.edit')->with(['user' => $user]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param1  paciente_id
     * @param2  int  $id
     * @param3 \Illuminate\Http\Response
     */

    public function historia($paciente_id,$especialidad_id,$medico_id)
    {
        if($especialidad_id=='ocupacional'){
             $especialidad_id=1;
        }elseif($especialidad_id=='ginecologia'){
            $especialidad_id=2;
        }elseif($especialidad_id=='pediatria'){
            $especialidad_id=3;
        }

       

        $medico_paciente = Medico_paciente::where(['paciente_id' => $paciente_id,'especialidad_id' => $especialidad_id,'medico_id' => $medico_id] )->first();

        $paciente = Paciente::where(['id'=>$paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $medico_id])->with('user')->first();

        if(is_null($medico_paciente)){

            $medico_paciente= new Medico_paciente;
            $medico_paciente->paciente()->associate($paciente_id);
            $medico_paciente->medico()->associate($medico_id);
            $medico_paciente->especialidad_id=$especialidad_id;
            $medico_paciente->save();
        }

         $historias=Historia_ocupacional::with('tipo_examen')->where('medico_paciente_id',$medico_paciente->id)->get();
         

        if($especialidad_id==1){

            return view('historias.historia.ocupacional.index')->with(['medico' => $medico,'paciente' => $paciente,'medico_paciente' => $medico_paciente,'historias' => $historias]);
            
        }elseif($especialidad_id==2){
            echo "Ginecologia";

        }elseif($especialidad_id==3){

            echo "Pediatria";
        }

    }


    public function ocupacional_create($paciente_id,$medico_paciente_id)
    {

        $medico_paciente = Medico_paciente::where(['id' => $medico_paciente_id] )->first();
        $paciente = Paciente::where(['id'=>$medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $medico_paciente->medico_id])->with('user')->first();

         return  view('historias.historia.ocupacional.create')->with(['paciente'=>$paciente,'medico'=>$medico,'medico_paciente'=>$medico_paciente ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
        
}
