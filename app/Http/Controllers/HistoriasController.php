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
use App\Examen_visual;
use App\Tipo_examen_visual;
use App\Ojo;
use App\Tipo_organo;
use App\Organo;
use App\Antecedente_ocupacional;
use App\Examen_laboratorio;
use App\Examen_fisico;
use App\Exploracion;
use App\Visual;
use App\Ocupacional_actual;
use App\Ocupacional_actual_factor_riesgo;
use App\Inmunizacion;
use App\Patologico;
use App\Ginecobstetrica;
use App\Habito_fumador;
use App\Habito_licor;
use App\Habito_medicamento;
use App\Antecedente_ocupacional_factor_riesgo;
use App\Lesion;
use App\Traumatologico;
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
        $role = User::find(Auth::user()->id)->roles()->pluck('descripcion');

        if($role->contains('medico')){
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
         
        }elseif($role->contains('administrador')){
          
            $querymedicos=Medico::with('user.roles');
            if($querymedicos->count()==0){

                flash('No existen médicos registrados en el sistema!', 'danger');
                return redirect()->route('home');
               
            }elseif($querymedicos->count()==1){

                $medicos=$querymedicos->first()->id;

            }else{
                
                foreach ($querymedicos->get() as $medico) {
                    $medicos[$medico->id]=$medico->user->tipodocumento.' '.$medico->user->numerodocumento.' '.$medico->user->primerapellido.' '.$medico->user->primernombre;
                }
            }
        }else{
            flash('No tiene permiso de entrar a esta área, por favor contacte al administrador!', 'danger');
            return redirect()->route('home');
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

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_ocupacional($paciente_id,$medico_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::findOrFail($historia_ocupacional_id);
        $historia_ocupacional->delete();
       
        flash('La historia ocupacional se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.historia',[$paciente_id,'ocupacional',$medico_id]);
    }


    public function ocupacional_create($paciente_id,$medico_paciente_id)
    {

        $medico_paciente = Medico_paciente::where(['id' => $medico_paciente_id] )->with('paciente')->first();
       
        $historia_ocupacional= new Historia_ocupacional;
        $historia_ocupacional->medico_paciente()->associate($medico_paciente);
        $historia_ocupacional->escolaridad()->associate(1);
        $historia_ocupacional->tipo_examen()->associate(1);
        $historia_ocupacional->empresa()->associate($medico_paciente->paciente->empresa_id);
        $historia_ocupacional->arl()->associate($medico_paciente->paciente->arl_id);
        $historia_ocupacional->afp()->associate($medico_paciente->paciente->afp_id);
        $historia_ocupacional->numerohijos=0;
        $historia_ocupacional->numeropersonascargo=0;
        $historia_ocupacional->empresa='';
        $historia_ocupacional->save();

        $Habito_fumador=new Habito_fumador;   
        $Habito_fumador->descripcion='No';
        $Habito_fumador->tiempo_fumador()->associate(1);
        $Habito_fumador->cantidad_fumador()->associate(1);
        $Habito_fumador->historia_ocupacional()->associate($historia_ocupacional);
        $Habito_fumador->save();

        $Habito_licor=new Habito_licor;   
        $Habito_licor->descripcion='No';
        $Habito_licor->tiempo_licor()->associate(1);
        $Habito_licor->tipolicor='';
        $Habito_licor->historia_ocupacional()->associate($historia_ocupacional);
        $Habito_licor->save();


        $Habito_medicamento=new Habito_medicamento;
        $Habito_medicamento->descripcion='No';
        $Habito_medicamento->regularidad_medicamento()->associate(1);
        $Habito_medicamento->nombremedicamento='';
        $Habito_medicamento->historia_ocupacional()->associate($historia_ocupacional);
        $Habito_medicamento->save();

        $paciente = Paciente::where(['id' => $paciente_id] )->with('user')->first();
        if($paciente->user->genero=='Femenino'){
            $Ginecobstetrica= new Ginecobstetrica;
            $Ginecobstetrica->fum=Carbon::createFromFormat('d/m/Y',date('d/m/Y'));
            $Ginecobstetrica->fuc=Carbon::createFromFormat('d/m/Y',date('d/m/Y'));
            $Ginecobstetrica->citologia='';
            $Ginecobstetrica->gravidez=0;
            $Ginecobstetrica->partos=0;
            $Ginecobstetrica->cesarias=0;
            $Ginecobstetrica->abortos=0;
            $Ginecobstetrica->dismenorrea=0;
            $Ginecobstetrica->historia_ocupacional()->associate($historia_ocupacional);
            $Ginecobstetrica->save();
        }

        $Ocupacional_actual=new Ocupacional_actual;
        $Ocupacional_actual->cargoactual='';
        $Ocupacional_actual->turno()->associate(1);
        $Ocupacional_actual->actividad()->associate(1);
        $Ocupacional_actual->historia_ocupacional()->associate($historia_ocupacional);
        $Ocupacional_actual->save();

        $Examen_fisico=new Examen_fisico;
        $Examen_fisico->peso= 0;
        $Examen_fisico->talla= 0;
        $Examen_fisico->imc= 0;
        $Examen_fisico->ta= '';
        $Examen_fisico->fc= '';
        $Examen_fisico->fr= '';
        $Examen_fisico->historia_ocupacional()->associate($historia_ocupacional);
        $Examen_fisico->lateralidad()->associate(1);
        $Examen_fisico->save();

  
       return redirect()->route('historias.ocupacional.edit',[$medico_paciente->paciente_id,$historia_ocupacional->id]);
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

        $resultados=[
            'tipo_examen_id' =>  $historia_ocupacional->tipo_examen_id,
            'empresa' => $historia_ocupacional->empresa,
            'empresa_id' => $historia_ocupacional->empresa_id,
            'arl_id' => $historia_ocupacional->arl_id,
            'afp_id' => $historia_ocupacional->afp_id,
            'escolaridad_id' => $historia_ocupacional->escolaridad_id,
            'numerohijos' => $historia_ocupacional->numerohijos,
            'numeropersonascargo' => $historia_ocupacional->numeropersonascargo
        ];

        return  view('historias.historia.ocupacional.ocupacional')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos,'resultados'=> $resultados ]);
    }
    public function ocupacional_edit_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
        
         $validator = Validator::make($request->all(), [
            'tipo_examen_id' => 'required|exists:tipo_examenes,id',
            'empresa' => 'required|string|max:100', 
            'empresa_id' => 'required|exists:empresas,id',
            'arl_id' => 'required|exists:arls,id',
            'afp_id' => 'required|exists:afps,id',
            'escolaridad_id' => 'required|exists:escolaridades,id',  
            'numerohijos' => 'required|integer|max:20',
            'numeropersonascargo' => 'required|integer|max:100',
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.edit',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }else{
            
            $historia_ocupacional->empresa=$request->empresa;
            $historia_ocupacional->numeropersonascargo=$request->numeropersonascargo;
            $historia_ocupacional->numerohijos=$request->numerohijos;
          
            $historia_ocupacional->tipo_examen()->associate($request->tipo_examen_id);
            $historia_ocupacional->escolaridad()->associate($request->escolaridad_id);
            $historia_ocupacional->empresa()->associate($request->empresa_id);
            $historia_ocupacional->arl()->associate($request->arl_id);
            $historia_ocupacional->afp()->associate($request->afp_id);
            $historia_ocupacional->save();


            flash('La actualización se realizó de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.edit',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }

  
    //PATOLOGIAS
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

        $Habito_fumador = Habito_fumador::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
        if($Habito_fumador)
        {
            $fumador=$Habito_fumador->descripcion;
            $tiempo_fumador_id=$Habito_fumador->tiempo_fumador_id;
            $cantidad_fumador_id=$Habito_fumador->cantidad_fumador_id;
        }else{

            $fumador='No';
            $tiempo_fumador_id=1;
            $cantidad_fumador_id=1;
        }

        $Habito_licor = Habito_licor::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
        if($Habito_licor)
        {
            $bebedor=$Habito_licor->descripcion;
            $tiempo_licor_id=$Habito_licor->tiempo_licor_id;
            $tipolicor=$Habito_licor->tipolicor;
        }else{

            $bebedor='No';
            $tiempo_licor_id=1;
            $tipolicor='';
        }

        $Habito_medicamento = Habito_medicamento::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
        if($Habito_medicamento)
        {
            $nombremedicamento=$Habito_medicamento->nombremedicamento;
            $regularidad_medicamento_id=$Habito_medicamento->regularidad_medicamento_id;
            $medicamento=$Habito_medicamento->descripcion;
        }else{
            $nombremedicamento='';
            $regularidad_medicamento_id=1;
            $medicamento='No';
        }



         $Ginecobstetrica = Ginecobstetrica::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
        if($Ginecobstetrica)
        {
            $fum=$Ginecobstetrica->fum;
            $fuc=$Ginecobstetrica->fuc;
            $citologia=$Ginecobstetrica->citologia;
            $dismenorrea=$Ginecobstetrica->dismenorrea;
            $gravidez=$Ginecobstetrica->gravidez;
            $partos=$Ginecobstetrica->partos;
            $cesarias=$Ginecobstetrica->cesarias;
            $abortos=$Ginecobstetrica->abortos;
           
        }else{

            $fum=date('d/m/Y');
            $fuc=date('d/m/Y');
            $citologia='';
            $dismenorrea=0;
            $gravidez=0;
            $partos=0;
            $cesarias=0;
            $abortos=0;
           
        } 

        

        $enfermedades = Patologico::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->with('enfermedad')->get();
        $inmunizaciones = Inmunizacion::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->get();
        $datos=['enfermedades'=>$enfermedades,'inmunizaciones'=>$inmunizaciones,'fumador'=> $fumador, 'tiempo_fumador_id'=> $tiempo_fumador_id, 'cantidad_fumador_id'=> $cantidad_fumador_id, 'nombremedicamento'=> $nombremedicamento, 'regularidad_medicamento_id'=> $regularidad_medicamento_id, 'medicamento'=> $medicamento, 'bebedor'=> $bebedor, 'tiempo_licor_id'=> $tiempo_licor_id, 'tipolicor'=> $tipolicor, 'fum' => $fum, 'fuc' => $fuc, 'citologia' => $citologia, 'dismenorrea' => $dismenorrea, 'gravidez' => $gravidez, 'partos' => $partos, 'cesarias' => $cesarias,'abortos'=>$abortos];

        return  view('historias.historia.ocupacional.patologias')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos,'datos'=>$datos ]);
    }

    public function Ocupacional_patologias_store_habitos(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
         
        $validator = Validator::make($request->all(), [
            'fumador' => 'required|string|max:10', 
            'tiempo_fumador_id' => 'required|exists:tiempo_fumadores,id', 
            'cantidad_fumador_id' => 'required|exists:cantidad_fumadores,id', 

            'bebedor' => 'required|string|max:10', 
            'tiempo_licor_id' => 'required|exists:tiempo_licores,id', 
            'tipolicor' => 'string|max:150',
            
            'medicamento'=>'required|string|max:10',
            'nombremedicamento'=>'string|max:150',
            'regularidad_medicamento_id'=>'required|exists:regularidad_medicamentos,id',
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{


            $Habito_fumador = Habito_fumador::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
            if(!$Habito_fumador)
            {
                $Habito_fumador=new Habito_fumador;
            }  
            $Habito_fumador->descripcion=$request->fumador;
            $Habito_fumador->tiempo_fumador()->associate($request->tiempo_fumador_id);
            $Habito_fumador->cantidad_fumador()->associate($request->cantidad_fumador_id);
            $Habito_fumador->historia_ocupacional()->associate($historia_ocupacional);
            $Habito_fumador->save();

            $Habito_licor = Habito_licor::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
            if(!$Habito_licor)
            {
                $Habito_licor=new Habito_licor;
            } 
            $Habito_licor->descripcion=$request->bebedor;
            $Habito_licor->tiempo_licor()->associate($request->tiempo_licor_id);
            $Habito_licor->tipolicor=$request->tipolicor;
            $Habito_licor->historia_ocupacional()->associate($historia_ocupacional);
            $Habito_licor->save();

            $Habito_medicamento = Habito_medicamento::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
            if(!$Habito_medicamento)
            {
                $Habito_medicamento=new Habito_medicamento;
            } 
            $Habito_medicamento->descripcion=$request->medicamento;
            $Habito_medicamento->regularidad_medicamento()->associate($request->regularidad_medicamento_id);
            $Habito_medicamento->nombremedicamento=$request->nombremedicamento;
            $Habito_medicamento->historia_ocupacional()->associate($historia_ocupacional);
            $Habito_medicamento->save();


            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }

    
    public function Ocupacional_patologias_store_vacuna(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'vacuna' => 'required|string|max:250', 
            'fecha' => 'required|date_format:d/m/Y',    
            'dosis' => 'string|max:250',   
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{

           
            $Inmunizacion=new Inmunizacion;
            $Inmunizacion->vacuna=$request->vacuna;
            $Inmunizacion->dosis=$request->dosis;
            $Inmunizacion->fecha=Carbon::createFromFormat('d/m/Y',$request->fecha);
            $Inmunizacion->historia_ocupacional()->associate($historia_ocupacional);
            $Inmunizacion->save();
            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }

    public function Ocupacional_patologias_store_enfermedad(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'enfermedad_id' => 'required|exists:enfermedades,id', 
            'observacion' => 'string|max:500',   
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{

            if($request->familiar=='on'){$familiar=true;}else{$familiar=false;}
            if($request->personal=='on'){$personal=true;}else{$personal=false;}
            $Patologico=new Patologico;
            $Patologico->familiar=$familiar;
            $Patologico->personal=$personal;
            $Patologico->observacion=$request->observacion;
            $Patologico->enfermedad()->associate($request->enfermedad_id);
            $Patologico->historia_ocupacional()->associate($historia_ocupacional);
            $Patologico->save();
            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }

    public function Ocupacional_patologias_store_ginecobstetrica(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'fum' => 'required|date_format:d/m/Y', 
            'fuc' => 'required|date_format:d/m/Y',   
            'citologia' => '    string|max:500',
            'dismenorrea' => 'required|boolean',    
            'gravidez' => 'required|integer|max:50',   
            'partos' => 'required|integer|max:50',   
            'abortos' => 'required|integer|max:50',
            'cesarias' => 'required|integer|max:50',   
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{

            
            $Ginecobstetrica = Ginecobstetrica::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
            if(!$Ginecobstetrica)
            {
                $Ginecobstetrica=new Ginecobstetrica;
            }    
            $Ginecobstetrica->fum=Carbon::createFromFormat('d/m/Y',$request->fum);
            $Ginecobstetrica->fuc=Carbon::createFromFormat('d/m/Y',$request->fuc);
            $Ginecobstetrica->citologia=$request->citologia;
            $Ginecobstetrica->gravidez=$request->gravidez;
            $Ginecobstetrica->partos=$request->partos;
            $Ginecobstetrica->cesarias=$request->cesarias;
            $Ginecobstetrica->abortos=$request->abortos;
            $Ginecobstetrica->dismenorrea=$request->dismenorrea;
            $Ginecobstetrica->historia_ocupacional()->associate($historia_ocupacional);
            $Ginecobstetrica->save();

            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }


    public function Ocupacional_patologias_destroy_enfermedad($paciente_id,$historia_ocupacional_id,$patologico_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $Patologico = Patologico::findOrFail($patologico_id);
        $Patologico->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
    }

    public function Ocupacional_patologias_destroy_vacuna($paciente_id,$historia_ocupacional_id,$inmunizacion_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $Inmunizacion = Inmunizacion::findOrFail($inmunizacion_id);
        $Inmunizacion->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
         return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
    }


    //OCUPACION ACTUAL
    public function ocupacional_actual($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $combos=array();
        $actividades = Actividad::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $turnos = Turno::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $factor_riesgos_query = Factor_riesgo::with('tipo_factor_riesgo')->orderby('tipo_factor_riesgo_id')->get();
        foreach ($factor_riesgos_query as $factor_riesgo) {
            $factor_riesgos[$factor_riesgo->id]=$factor_riesgo->tipo_factor_riesgo->descripcion.' > '.$factor_riesgo->descripcion;
        }

        $Ocupacional_actual = Ocupacional_actual::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
        $factores=array();
        if($Ocupacional_actual)
        {
            $actividad_id=$Ocupacional_actual->actividad_id;
            $cargoactual=$Ocupacional_actual->cargoactual;
            $turno_id=$Ocupacional_actual->turno_id;
            $factores = Ocupacional_actual_factor_riesgo::with('factor_riesgo.tipo_factor_riesgo')->where(['ocupacional_actual_id'=> $Ocupacional_actual->id])->orderby('id')->get();
            $mostrar_fatores=true;
        }else{
            $mostrar_fatores=false;
            $ocupacional_actual_factores=array();
            $actividad_id=1;
            $cargoactual='';
            $turno_id=1;
        }


        
        $datos=['factores'=>$factores,'actividad_id'=>$actividad_id,'cargoactual'=>$cargoactual,'turno_id'=>$turno_id,'mostrar_fatores'=>$mostrar_fatores];

        $combos=[ 'turnos' => $turnos,'actividades' => $actividades,'factor_riesgos' => $factor_riesgos];

        return  view('historias.historia.ocupacional.actual')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos,'datos'=>$datos ]);
    }

    public function Ocupacional_actual_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'cargoactual' => 'required|string|max:250', 
            'turno_id' => 'required|exists:turnos,id',   
            'actividad_id' => 'required|exists:actividades,id',   
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.actual',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{

            $Ocupacional_actual = Ocupacional_actual::where(['historia_ocupacional_id' => $historia_ocupacional->id])->first();

            if(is_null($Ocupacional_actual))
            {
                $Ocupacional_actual=new Ocupacional_actual;
            }
            $Ocupacional_actual->cargoactual=$request->cargoactual;
            $Ocupacional_actual->turno()->associate($request->turno_id);
            $Ocupacional_actual->actividad()->associate($request->actividad_id);
            $Ocupacional_actual->historia_ocupacional()->associate($historia_ocupacional);
            $Ocupacional_actual->save();
            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.actual',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }


    public function Ocupacional_actual_store_factor(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'factor_riesgo_id' => 'required|exists:factor_riesgos,id',   
            'otro' => 'string|max:250',   
            'tiempoexposicion' => 'string|max:250',
            'medidacontrol' => 'string|max:250',
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.actual',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{

            $Ocupacional_actual = Ocupacional_actual::where(['historia_ocupacional_id' => $historia_ocupacional->id])->first();
            if(!is_null($Ocupacional_actual))
            {
                if(is_null($request->otro)){
                    $otro='';
                }else{
                    $otro=$request->otro;
                }
                $Ocupacional_actual_factor_riesgo=new Ocupacional_actual_factor_riesgo;
                $Ocupacional_actual_factor_riesgo->tiempoexposicion=$request->tiempoexposicion;
                $Ocupacional_actual_factor_riesgo->medidacontrol=$request->medidacontrol;
                $Ocupacional_actual_factor_riesgo->otro=$otro;
                $Ocupacional_actual_factor_riesgo->factor_riesgo()->associate($request->factor_riesgo_id);
                $Ocupacional_actual_factor_riesgo->ocupacional_actual()->associate($Ocupacional_actual);
                $Ocupacional_actual_factor_riesgo->save();
                flash('Se ha registrado la información de forma exitosa!', 'success');
            }
            return redirect()->route('historias.ocupacional.actual',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }

    public function Ocupacional_actual_destroy_factor($paciente_id,$historia_ocupacional_id,$ocupacional_actual_factor_riesgo_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $Ocupacional_actual_factor_riesgo_id = Ocupacional_actual_factor_riesgo::findOrFail($ocupacional_actual_factor_riesgo_id);
        $Ocupacional_actual_factor_riesgo_id->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.actual',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }


    //DIAGNOSTICOS
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
        $diagnosticos= Diagnostico::where(['historia_ocupacional_id' => $historia_ocupacional->id])->with('tipo_diagnostico')->orderBy('id')->get();

        $combos=[ 'tipo_diagnosticos' => $tipo_diagnosticos,'diagnosticos'=>$diagnosticos];

        return  view('historias.historia.ocupacional.diagnosticos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos ]);
    }

    public function ocupacional_diagnosticos_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'concepto' => 'required|string|max:250', 
            'tipo_diagnostico_id' => 'required|exists:tipo_diagnosticos,id',   
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.diagnosticos',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{
            
            $Diagnostico=new Diagnostico;
            $Diagnostico->tipo_diagnostico()->associate($request->tipo_diagnostico_id);
            $Diagnostico->historia_ocupacional()->associate($historia_ocupacional);
            $Diagnostico->concepto=$request->concepto;
            $Diagnostico->save();
            flash('Se ha registrado el diagnóstico de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.diagnosticos',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }

    public function ocupacional_diagnosticos_destroy($paciente_id,$historia_ocupacional_id,$diagnostico_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $Diagnostico = Diagnostico::findOrFail($diagnostico_id);
        $Diagnostico->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.diagnosticos',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }

    //EXAMENES
    public function ocupacional_examenes($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();
        $examen_laboratorios= Examen_laboratorio::where(['historia_ocupacional_id' => $historia_ocupacional->id])->orderBy('id')->get();
        $combos=['examen_laboratorios'=>$examen_laboratorios];
        return  view('historias.historia.ocupacional.examenes')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos' => $combos]);
    }
     public function ocupacional_examenes_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'examen' => 'required|string|max:250', 
            'fecha' => 'required|date_format:d/m/Y',   
            'resultado' => 'required|string|max:250', 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.examenes',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{
            
            $Examen_laboratorio=new Examen_laboratorio;
            $Examen_laboratorio->fecha = Carbon::createFromFormat('d/m/Y',$request->fecha);
            $Examen_laboratorio->examen=$request->examen;
            $Examen_laboratorio->resultado=$request->resultado;
            $Examen_laboratorio->historia_ocupacional()->associate($historia_ocupacional);
            $Examen_laboratorio->save();
            flash('Se ha registrado el examen de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.examenes',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }

    public function ocupacional_examenes_destroy($paciente_id,$historia_ocupacional_id,$examen_laboratorio_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $Examen_laboratorio = Examen_laboratorio::findOrFail($examen_laboratorio_id);
        $Examen_laboratorio->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.examenes',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }

    //EXAMENES FISICOS
    public function ocupacional_fisicos($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $datos=array();
        $Examen_fisico = Examen_fisico::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
       
        if($Examen_fisico)
        {
            $lateralidad_id=$Examen_fisico->lateralidad_id;
            $peso=$Examen_fisico->peso;
            $talla=$Examen_fisico->talla;
            $imc=$Examen_fisico->imc;
            $ta=$Examen_fisico->ta;
            $fc=$Examen_fisico->fc;
            $fr=$Examen_fisico->fr;

        }else{

            $lateralidad_id=1;
            $peso='0.00';
            $talla='0.00';
            $imc='0.00';
            $ta='';
            $fc='';
            $fr='';
        }
        $datos=['lateralidad_id'=>$lateralidad_id, 'peso'=>$peso, 'talla'=>$talla, 'imc'=>$imc, 'ta'=>$ta, 'fc'=>$fc, 'fr'=>$fr];

        $combos=array();
        $lateralidades = Lateralidad::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
      

        $examenes_ocupacionales=array();
        $tipo_organos_query = Tipo_organo::orderby('id')->get();
        foreach ($tipo_organos_query as $tipo_organo) {
            $organos_query = Organo::where('tipo_organo_id',$tipo_organo->id)->orderby('descripcion')->get();
            $organos= array();
            foreach ($organos_query as $organo) {
              $exploracion = Exploracion::where(['historia_ocupacional_id'=> $historia_ocupacional->id,'organo_id' =>  $organo->id ])->first();
              if(is_null($exploracion))
              {
                $resultado='';
                $check=false;
                $disabled='disabled';
              }else{
                $resultado=$exploracion->resultado;
                $check=true;
                $disabled='';
              }  
              $organos[]=['id' => $organo->id,'descripcion' => $organo->descripcion,'resultado' =>$resultado,'check' => $check,'disabled'=>$disabled];
            }

            $examenes_ocupacionales[]=[ 'id' => $tipo_organo->id,'descripcion' => $tipo_organo->descripcion, 'organos' => $organos];
        }

        $examenes_visuales=array();
        $Tipo_examen_visual_query = Tipo_examen_visual::orderby('id')->get();
        foreach ($Tipo_examen_visual_query as $tipo_examen_visual) {

            $Examen_visual_query = Examen_visual::where('tipo_examen_visual_id',$tipo_examen_visual->id)->with('ojo')->orderby('id')->get();
            $examen_visuales= array();
            foreach ($Examen_visual_query as $examen_visual) {
                if($examen_visual->ojo_id == 3){
                    $ambos='Ojos';
                    $ojo='';
                }else{
                    $ambos='';
                    $ojo='Ojo';
                }
                $visual = Visual::where(['historia_ocupacional_id'=> $historia_ocupacional->id,'examen_visual_id' =>  $examen_visual->id ])->first();
                if(is_null($visual))
                {
                    $observacion='';
                    $check=false;
                    $disabled='disabled';
                }else{
                    $observacion=$visual->descripcion;
                    $check=true;
                    $disabled='';
                }  
                $examen_visuales[]=['id' => $examen_visual->id,'descripcion' => $ojo.' '.$examen_visual->ojo->descripcion.' '.$ambos,'observacion' =>$observacion,'check' => $check,'disabled'=>$disabled];

            }

            $examenes_visuales[]=[ 'id' => $tipo_examen_visual->id,'descripcion' => $tipo_examen_visual->descripcion, 'examen_visuales' => $examen_visuales];
        }
        $combos=[ 'lateralidades' => $lateralidades,'examenes_ocupacionales' => $examenes_ocupacionales,'examenes_visuales'=>$examenes_visuales];
        return  view('historias.historia.ocupacional.fisicos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=> $combos, 'datos' =>  $datos]);
    }

    public function ocupacional_fisicos_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
       
        $validator = Validator::make($request->all(), [
      
            'peso' => 'required|numeric', 
            'talla' => 'required|numeric', 
            'imc' => 'required|numeric', 
            'ta' => 'required|string|max:10', 
            'fc' => 'required|string|max:10', 
            'fr' => 'required|string|max:10', 
            'lateralidad_id' => 'required|exists:lateralidades,id', 
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->id,$historia_ocupacional->id])->withInput();
        }else{

            $Examen_fisico = Examen_fisico::where(['historia_ocupacional_id' => $historia_ocupacional->id])->first();
          
            if(is_null($Examen_fisico))
            {
                $Examen_fisico=new Examen_fisico;
            }
           
            $Examen_fisico->peso= $request->peso;
            $Examen_fisico->talla= $request->talla;
            if($request->peso>0 && $request->talla>0){
                $imc=$request->peso/($request->talla*$request->talla);
            }else{
                $imc=0;
            }
            $Examen_fisico->imc= $imc;
            $Examen_fisico->ta= $request->ta;
            $Examen_fisico->fc= $request->fc;
            $Examen_fisico->fr= $request->fr;
            $Examen_fisico->historia_ocupacional()->associate($historia_ocupacional);
            $Examen_fisico->lateralidad()->associate($request->lateralidad_id);
            $Examen_fisico->save();

            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->id,$historia_ocupacional->id]);
        }
    }

    public function ocupacional_fisicos_store_exploracion(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
        
        $organos_query = Organo::orderby('descripcion')->get();
        $organos= array();
        foreach ($organos_query as $organo) {

           $Exploracion = Exploracion::where(['organo_id' => $organo->id,'historia_ocupacional_id'=>$historia_ocupacional->id])->first();   
           if($request[$organo->id]) {
                
                if(is_null($Exploracion))
                {
                    $Exploracion= new Exploracion;
                    $Exploracion->resultado=$request[$organo->id];
                    $Exploracion->historia_ocupacional()->associate($historia_ocupacional);
                    $Exploracion->organo()->associate($organo->id);
                    $Exploracion->save();
                }else{
                    $Exploracion->resultado=$request[$organo->id];
                    $Exploracion->save();
                }
           }else{
                if(!is_null($Exploracion))
                {
                    $Exploracion->delete();
                }
           }
        }

        flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->id,$historia_ocupacional->id]);
    }

     public function ocupacional_fisicos_store_visual(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
        
        $examen_visuales_query = Examen_visual::orderby('id')->get();
        $examen_visuales= array();
        foreach ($examen_visuales_query as $examen_visual) {

           $Visual = Visual::where(['examen_visual_id' => $examen_visual->id,'historia_ocupacional_id'=>$historia_ocupacional->id])->first();   
           if($request[$examen_visual->id]) {
                
                if(is_null($Visual))
                {
                    $Visual= new Visual;
                    $Visual->descripcion=$request[$examen_visual->id];
                    $Visual->historia_ocupacional()->associate($historia_ocupacional);
                    $Visual->examen_visual()->associate($examen_visual->id);
                    $Visual->save();
                }else{
                    $Visual->descripcion=$request[$examen_visual->id];
                    $Visual->save();
                }
           }else{
                if(!is_null($Visual))
                {
                    $Visual->delete();
                }
           }
        }

        flash('Se ha registrado la información de forma exitosa!', 'success');
        return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->id,$historia_ocupacional->id]);
    }

    

    //ANTECEDENTES
    public function ocupacional_antecedentes($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();
        $antecedente_ocupacionales = Antecedente_ocupacional::where(['historia_ocupacional_id' => $historia_ocupacional->id])->get();
        $combos=array();
        $combos=['antecedente_ocupacionales'=>$antecedente_ocupacionales];
       
         return  view('historias.historia.ocupacional.antecedentes')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=> $combos]);
    }

    public function ocupacional_antecedentes_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();
        $antecedente_ocupacionales = Antecedente_ocupacional::where(['historia_ocupacional_id' => $historia_ocupacional->id])->get();
        $combos=array();
        $combos=['antecedente_ocupacionales'=>$antecedente_ocupacionales];

         $validator = Validator::make($request->all(), [
            'empresa' => 'required|string|max:100', 
            'tiemposervicio' => 'required|string|max:50',   
            'ocupacion' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.antecedentes',[$paciente->id,$historia_ocupacional->id])->withInput();
        }else{

            $Antecedente_ocupacional=new Antecedente_ocupacional;
            $Antecedente_ocupacional->empresa=$request->empresa;
            $Antecedente_ocupacional->tiemposervicio=$request->tiemposervicio;
            $Antecedente_ocupacional->ocupacion=$request->ocupacion;
            $Antecedente_ocupacional->historia_ocupacional()->associate($historia_ocupacional);
            $Antecedente_ocupacional->save();
            flash('Se ha registrado la empresa '.$request->empresa.' de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.antecedentes',[$paciente->id,$historia_ocupacional->id]);
        }
    }

    public function ocupacional_antecedentes_destroy($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $Antecedente_ocupacional = Antecedente_ocupacional::findOrFail($antecedente_ocupacional_id);
        $Antecedente_ocupacional->delete();
        flash('La empresa '.$Antecedente_ocupacional->empresa.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.antecedentes',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }

    public function ocupacional_antecedentes_riesgos($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $antecedente_ocupacional = Antecedente_ocupacional::where(['id' => $antecedente_ocupacional_id] )->first();
         $factor_riesgos=array();
        $factor_riesgos_query = Factor_riesgo::with('tipo_factor_riesgo')->orderby('tipo_factor_riesgo_id')->get();
        foreach ($factor_riesgos_query as $factor_riesgo) {
            $factor_riesgos[$factor_riesgo->id]=$factor_riesgo->tipo_factor_riesgo->descripcion.' > '.$factor_riesgo->descripcion;
        }
        $factores = Antecedente_ocupacional_factor_riesgo::with('factor_riesgo.tipo_factor_riesgo')->where(['antecedente_ocupacional_id'=> $antecedente_ocupacional_id])->get();
      
        $combos=['factor_riesgos' => $factor_riesgos,'factores'=>$factores];
        return  view('historias.historia.ocupacional.antecedente.riesgos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'antecedente_ocupacional'=>$antecedente_ocupacional,'combos'=> $combos]);
    }

    public function ocupacional_antecedentes_riesgos_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'factor_riesgo_id' => 'required|exists:factor_riesgos,id',   
            'otro' => 'string|max:250',   
            'tiempoexposicion' => 'string|max:250',
            'medidacontrol' => 'string|max:250',
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.antecedentes.riesgos',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id,$antecedente_ocupacional_id])->withInput();
        }else{

            $antecedente_ocupacional = Antecedente_ocupacional::where(['id' => $request->antecedente_ocupacional_id])->first();
            if(!is_null($antecedente_ocupacional))
            {
                if(is_null($request->otro)){
                    $otro='';
                }else{
                    $otro=$request->otro;
                }
                $Antecedente_ocupacional_factor_riesgo=new Antecedente_ocupacional_factor_riesgo;
                $Antecedente_ocupacional_factor_riesgo->tiempoexposicion=$request->tiempoexposicion;
                $Antecedente_ocupacional_factor_riesgo->medidacontrol=$request->medidacontrol;
                $Antecedente_ocupacional_factor_riesgo->otro=$otro;
                $Antecedente_ocupacional_factor_riesgo->factor_riesgo()->associate($request->factor_riesgo_id);
                $Antecedente_ocupacional_factor_riesgo->antecedente_ocupacional()->associate($antecedente_ocupacional);
                $Antecedente_ocupacional_factor_riesgo->save();
                flash('Se ha registrado la información de forma exitosa!', 'success');
            }
            return redirect()->route('historias.ocupacional.antecedentes.riesgos',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id,$antecedente_ocupacional->id]);
        }
    }

    public function ocupacional_antecedentes_destroy_riesgo($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id,$antecedente_ocupacional_factor_riesgo_id)
    {
        $Antecedente_ocupacional_factor_riesgo = Antecedente_ocupacional_factor_riesgo::findOrFail($antecedente_ocupacional_factor_riesgo_id);
        $Antecedente_ocupacional_factor_riesgo->delete();
        flash('La información se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.antecedentes.riesgos',[$paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id]);
    }

    public function ocupacional_antecedentes_lesiones($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $antecedente_ocupacional = Antecedente_ocupacional::where(['id' => $antecedente_ocupacional_id] )->first();
        $lesiones=array();
        $lesiones_query = Lesion::orderby('descripcion')->get();
        foreach ($lesiones_query as $lesion) {
            $lesiones[$lesion->id]=$lesion->descripcion;
        }
        $traumatologicos = Traumatologico::with('lesion')->where(['antecedente_ocupacional_id'=> $antecedente_ocupacional_id])->get();
      
        $combos=['lesiones' => $lesiones,'traumatologicos'=>$traumatologicos];
        return  view('historias.historia.ocupacional.antecedente.traumatologicos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'antecedente_ocupacional'=>$antecedente_ocupacional,'combos'=> $combos]);
    }

    public function ocupacional_antecedentes_lesiones_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'lesion_id' => 'required|exists:lesiones,id',   
            'otros' => 'string|max:250',   
            'secuela' => 'string|max:250',
            'arl' => 'string|max:250',
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.antecedentes.lesiones',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id,$antecedente_ocupacional_id])->withInput();
        }else{

            $antecedente_ocupacional = Antecedente_ocupacional::where(['id' => $request->antecedente_ocupacional_id])->first();
            if(!is_null($antecedente_ocupacional))
            {
                if(is_null($request->otro)){
                    $otro='';
                }else{
                    $otro=$request->otro;
                }
                $Traumatologico=new Traumatologico;
                $Traumatologico->secuela=$request->secuela;
                $Traumatologico->arl=$request->arl;
                $Traumatologico->otro=$otro;
                $Traumatologico->lesion()->associate($request->lesion_id);
                $Traumatologico->antecedente_ocupacional()->associate($antecedente_ocupacional);
                $Traumatologico->save();
                flash('Se ha registrado la información de forma exitosa!', 'success');
            }
            return redirect()->route('historias.ocupacional.antecedentes.lesiones',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id,$antecedente_ocupacional->id]);
        }
    }

    public function ocupacional_antecedentes_destroy_lesion($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id,$tramatologico_id)
    {
        $Traumatologico = Traumatologico::findOrFail($tramatologico_id);
        $Traumatologico->delete();
        flash('La información se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.antecedentes.lesiones',[$paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id]);
    }
  
        
}
