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
use App\Escolaridad;
use App\Tipo_examen;
use App\Tipo_factor_riesgo;
use App\Factor_riesgo;
use App\Enfermedad;
use App\Turno;
use App\Actividad;
use App\Tiempo_fumador;
use App\Cantidad_fumador;
use App\Tiempo_licor;
use App\Regularidad_medicamento;
use App\Empresa;
use App\Arl;
use App\Afp;
use App\Diagnostico;
use App\Tipo_diagnostico;
use App\Lateralidad;
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

        $historia_ocupacional= new Historia_ocupacional;
        $historia_ocupacional->medico_paciente()->associate($medico_paciente);
        $historia_ocupacional->escolaridad()->associate(1);
        $historia_ocupacional->tipo_examen()->associate(1);
        $historia_ocupacional->empresa()->associate($paciente->empresa_id);
        $historia_ocupacional->arl()->associate($paciente->arl_id);
        $historia_ocupacional->afp()->associate($paciente->afp_id);
        $historia_ocupacional->numerohijos=0;
        $historia_ocupacional->numeropersonascargo=0;
        $historia_ocupacional->empresa='';
        $historia_ocupacional->save();
      
        /*Combos*/
        $combos=array();
        $empresas=Empresa::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $arls=Arl::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $afps=Afp::all()->sortBy('descripcion')->pluck('descripcion', 'id');
       $tipo_examenes = Tipo_examen::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $escolaridades = Escolaridad::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $combos=['tipo_examenes' => $tipo_examenes,'escolaridades' => $escolaridades,'empresas' => $empresas,'arls' => $arls,'afps' => $afps];

        return  view('historias.historia.ocupacional.ocupacional')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos ]);
    }


    public function ocupacional_edit($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $combos=array();
        $empresas=Empresa::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $arls=Arl::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $afps=Afp::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $tipo_examenes = Tipo_examen::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $escolaridades = Escolaridad::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $combos=['tipo_examenes' => $tipo_examenes,'escolaridades' => $escolaridades,'empresas' => $empresas,'arls' => $arls,'afps' => $afps];
        return  view('historias.historia.ocupacional.ocupacional')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos ]);
    }

    public function ocupacional_patologias($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $combos=array();
        $tiempo_fumadores = Tiempo_fumador::all()->sortBy('id')->pluck('descripcion','id');
        $cantidad_fumadores = Cantidad_fumador::all()->sortBy('id')->pluck('descripcion','id');
        $tiempo_licores = Tiempo_licor::all()->sortBy('id')->pluck('descripcion','id');
        $regularidad_medicamentos = Regularidad_medicamento::all()->sortBy('id')->pluck('descripcion','id');
        $enfermedades = Enfermedad::all()->sortBy('descripcion')->pluck('descripcion','id');
        $combos=['enfermedades' => $enfermedades,'tiempo_fumadores' => $tiempo_fumadores,'cantidad_fumadores' => $cantidad_fumadores,'tiempo_licores' => $tiempo_licores,'regularidad_medicamentos' => $regularidad_medicamentos];
        return  view('historias.historia.ocupacional.patologias')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos ]);
    }


    public function ocupacional_actual($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $combos=array();
        $actividades = Actividad::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $turnos = Turno::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $factor_riegos_query = Factor_riesgo::with('tipo_factor_riesgo')->orderby('tipo_factor_riesgo_id')->get();
        foreach ($factor_riegos_query as $factor_riego) {
            $factor_riesgos[$factor_riego->id]=$factor_riego->tipo_factor_riesgo->descripcion.' > '.$factor_riego->descripcion;
        }
        $combos=[ 'turnos' => $turnos,'actividades' => $actividades,'factor_riesgos' => $factor_riesgos];
        return  view('historias.historia.ocupacional.actual')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos ]);
    }

    public function ocupacional_diagnosticos($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $combos=array();
        $tipo_diagnosticos=array();
        $tipo_diagnosticos_query = Tipo_diagnostico::orderby('codigo')->get();
        foreach ($tipo_diagnosticos_query as $tipo_diagnostico) {
            $tipo_diagnosticos[$tipo_diagnostico->id]=$tipo_diagnostico->codigo.' > '.$tipo_diagnostico->descripcion;
        }

        $combos=[ 'tipo_diagnosticos' => $tipo_diagnosticos];
        return  view('historias.historia.ocupacional.diagnosticos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos ]);
    }


    public function ocupacional_examenes($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();
          return  view('historias.historia.ocupacional.examenes')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional]);
    }

    public function ocupacional_fisicos($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();
        $combos=array();
        $lateralidades = Lateralidad::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $combos=[ 'lateralidades' => $lateralidades];
      
         return  view('historias.historia.ocupacional.fisicos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=> $combos]);
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
