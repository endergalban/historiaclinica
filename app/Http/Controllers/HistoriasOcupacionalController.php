<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Crypt;
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
use App\Condicion_diagnostico;
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
use App\Condicion_altura;
use App\Tipo_examen_altura;
use App\Examen_altura;
use App\Tipo_consentimiento;
use App\Consentimiento;
use App\Tipo_condicion;
use Auth;

class HistoriasOcupacionalController extends Controller
{

	public function index($paciente_id,$medico_paciente_id)
    {
    	$medico_paciente=Medico_paciente::where('id',$medico_paciente_id)->first();
      	$historia_ocupacionales=Historia_ocupacional::with('tipo_examen')->where('medico_paciente_id',$medico_paciente->id)->orderby('id','DESC')->  get();
		$paciente=Paciente::where('id',$medico_paciente->paciente_id)->with('user')->first();
		$medico=Medico::where('id',$medico_paciente->medico_id)->with('user')->first();

        if(Auth::user()->roles()->get()->whereIn('id',[1,2])->count()==0)
        {$acciones=false;}else{$acciones=true;}     
        
        return view('historias.historia.ocupacional.index')->with(['medico' => $medico,'paciente' => $paciente,'medico_paciente' => $medico_paciente,'historia_ocupacionales' => $historia_ocupacionales,'acciones'=> $acciones]);
    }
   
    public function ocupacional_create($paciente_id,$medico_paciente_id)
    {

        $medico_paciente = Medico_paciente::where(['id' => $medico_paciente_id] )->with('paciente')->first();
       

        Historia_ocupacional::where('medico_paciente_id', '=', $medico_paciente_id)->update(['activa' => 0]);

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
        $historia_ocupacional->recomendaciones='';
        $historia_ocupacional->activa=1;
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

        $Condicion_altura=new Condicion_altura;
        $Condicion_altura->observacion= '';
        $Condicion_altura->historia_ocupacional()->associate($historia_ocupacional);
        $Condicion_altura->tipo_condicion()->associate(1);
        $Condicion_altura->save();

        $Condicion_diagnostico=new Condicion_diagnostico;
        $Condicion_diagnostico->observacion= '';
        $Condicion_diagnostico->historia_ocupacional()->associate($historia_ocupacional);
        $Condicion_diagnostico->tipo_condicion()->associate(1);
        $Condicion_diagnostico->save();
        return redirect()->route('historias.ocupacional.edit',[$medico_paciente->paciente_id,$historia_ocupacional->id]);

    }

      /**
     * .
     * Eliminar Historia Ocupacional
     * @param  $paciente_id,$medico_id,$historia_ocupacional_id
     */
    public function destroy_ocupacional($paciente_id,$medico_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $historia_ocupacional->delete();
        flash('La historia ocupacional se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.historia',[$paciente_id,'ocupacional',$medico_id]);
    }

    /**
     * .
     * Crea una nueva historia ocupacional con todos los datos hijos por defecto
     * @param $paciente_id,$medico_paciente_id
     */

     /**
     * .
     * Muestra los documentos anexo a la historia ocupacional seleccionada
     * @param  paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_documentos($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();
       

        $files = Storage::disk('ocupacional')->files($historia_ocupacional_id);
        $arrayfiles=array();
        foreach ($files as $file ) {
            
            $nombre= pathinfo(storage_path('app/public/ocupacional/'.$historia_ocupacional_id).$file, PATHINFO_BASENAME);
            $size = Storage::disk('ocupacional')->getSize($file);    
            $tipo =pathinfo(storage_path('app/public/ocupacional/'.$historia_ocupacional_id).$file, PATHINFO_EXTENSION);
            if($tipo=='pdf')
            {
                $tipo='fa-file-pdf-o';
            }elseif($tipo=='xlsx' || $tipo=='xls'){
                $tipo='fa-file-excel-o';
            }elseif($tipo=='doc' || $tipo=='docx'){
                 $tipo='fa-file-word-o';
            }elseif($tipo=='ppt' || $tipo=='pptx'){
                 $tipo='fa-file-powerpoint-o';
            }elseif($tipo=='jpeg' || $tipo=='bmp' || $tipo=='png' || $tipo=='jpg' ){
                $tipo='fa-file-image-o';
            }
            $arrayfiles[]=['nombre'=>$nombre,'size'=>$this->formatBytes($size),'tipo'=> $tipo,'ruta'=> $file];
        }
        return  view('historias.historia.ocupacional.documentos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'files' => $arrayfiles ]);
    }
    /**
     * .
     * Registra un documento a la historia ocupacional seleccionada
     * @param $request del documento
     */
    public function ocupacional_documentos_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
        
         $validator = Validator::make($request->all(), [
            
            'documento' => 'required|mimes:pdf,jpeg,bmp,png,jpg,doc,xls,ppt,docx,xlsx,pptx', 
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.documentos',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }else{
            $file = $request->file('documento');
            Storage::disk('ocupacional')->putFileAs($historia_ocupacional->id, $file,$file->getClientOriginalName());
         
            flash('El documento se guardo de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.documentos',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }

    /**
     * .
     * Elimina un documento de la historia ocupacional seleccionada
     * @param paciente_id,$historia_ocupacional_id,$documento
     */
    public function ocupacional_documentos_destroy($paciente_id,$historia_ocupacional_id,$documento)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        Storage::disk('ocupacional')->delete(Crypt::decrypt($documento));
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.documentos',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }

    //DATOS DEL PACIENTE
     /**
     * .
     * Muestra los datos básicos de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_edit($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
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


     /**
     * .
     * Actualiza los datos básicos de la historia ocupacional seleccionada
     * @param $request con los datos de actualización
     */
    public function ocupacional_edit_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
        
         $validator = Validator::make($request->all(), [
            'tipo_examen_id' => 'required|exists:tipo_examenes,id|not_in:1',
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
            if($request->tipo_examen_id!=$historia_ocupacional->tipo_examen_id)
            {

                $Condicion_diagnostico = Condicion_diagnostico::where(['historia_ocupacional_id' => $historia_ocupacional->id])->first();
                if(!is_null($Condicion_diagnostico))
                {
                    
                    $Condicion_diagnostico->observacion= '';
                    $Condicion_diagnostico->tipo_condicion()->associate(1);
                    $Condicion_diagnostico->save();
                }
                
            }
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

    //CONSENTIMIENTOS
     /**
     * .
     * Muestra los datos básicos de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_consentimientos($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $combos=array();
        $Tipo_consentimientos_query=Tipo_consentimiento::all()->sortBy('id');
        $Tipo_consentimientos=array();
        $otro='';
        foreach ($Tipo_consentimientos_query as $Tipo_consentimiento) {

            $Consentimiento=Consentimiento::where(['tipo_consentimiento_id' => $Tipo_consentimiento->id,'historia_ocupacional_id'=> $historia_ocupacional->id ])->first();
            if(is_null($Consentimiento))
            {
                $valor=false;
            }else{
                $valor=true;
                if($Tipo_consentimiento->descripcion=='Otros'){
                    $otro=$Consentimiento->otro;
                }
            }
           
            $Tipo_consentimientos[]=['id' => $Tipo_consentimiento->id,'descripcion' =>$Tipo_consentimiento->descripcion, 'valor' =>$valor];
        }


        $combos=['Tipo_consentimientos' => $Tipo_consentimientos,'otro'=>$otro];

      
        return  view('historias.historia.ocupacional.consentimientos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos]);
    }

    /**
     * .
     * Actualiza los datos básicos de la historia ocupacional seleccionada
     * @param $request con los datos de actualización
     */
    public function ocupacional_consentimientos_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
        
        $Tipo_consentimientos_query=Tipo_consentimiento::all()->sortBy('id');
        foreach ($Tipo_consentimientos_query as $Tipo_consentimiento) {

             $Consentimiento=Consentimiento::where(['tipo_consentimiento_id' => $Tipo_consentimiento->id,'historia_ocupacional_id'=> $historia_ocupacional->id ])->first();
            if(isset($request[$Tipo_consentimiento->id])){
                if(is_null($Consentimiento))
                {
                    $Consentimiento = new Consentimiento;   
                    $Consentimiento->otro= $request->otro;
                    $Consentimiento->historia_ocupacional()->associate($historia_ocupacional);
                    $Consentimiento->tipo_consentimiento()->associate($request[$Tipo_consentimiento->id]);
                    $Consentimiento->save();
                
                }else{
                    if($Tipo_consentimiento->descripcion=='Otros')
                    {
                        $Consentimiento->otro= $request->otro;
                        $Consentimiento->save();    
                    }
                }
            }else{
                if(!is_null($Consentimiento))
                {
                    $Consentimiento->delete();
                }
            }
           
        }

        flash('La actualización se realizó de forma exitosa!', 'success');
        return redirect()->route('historias.ocupacional.consentimientos',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        
    }   

    //OCUPACION ACTUAL
    /**
     * .
     * Muestra los datos de la ocupación actual de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_actual($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
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
    /**
     * .
     * Actualiza los datos de la ocupación actual de la historia ocupacional seleccionada
     * @param $request de los datos de la ocupación actual
     */
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

    /**
     * .
     * Registra un factor de riesgo a la ocupación actual de la historia ocupacional seleccionada
     * @param $request de los datos de factor de riesgo de la ocupación actual
     */
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
    /**
     * .
     * Elimina un factor de riesgo a la ocupación actual de la historia ocupacional seleccionada
     * @param paciente_id,$historia_ocupacional_id,$ocupacional_actual_factor_riesgo_id
     */
    public function Ocupacional_actual_destroy_factor($paciente_id,$historia_ocupacional_id,$ocupacional_actual_factor_riesgo_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $Ocupacional_actual_factor_riesgo_id = Ocupacional_actual_factor_riesgo::find($ocupacional_actual_factor_riesgo_id);
        $Ocupacional_actual_factor_riesgo_id->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.actual',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }

    //ANTECEDENTES
    /**
     * .
     * Muestra las empresas de los antecedentes de la historia ocupacional seleccionada
     * @param $request de los datos de la empresa
     */
    public function ocupacional_antecedentes($paciente_id,$historia_ocupacional_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();
        $antecedente_ocupacionales = Antecedente_ocupacional::where(['historia_ocupacional_id' => $historia_ocupacional->id])->get();
        $combos=array();
        $combos=['antecedente_ocupacionales'=>$antecedente_ocupacionales];
       
         return  view('historias.historia.ocupacional.antecedentes')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=> $combos]);
    }

    /**
     * .
     * Registra una empresa a los antecedentes de la historia ocupacional seleccionada
     * @param $request de los datos de la empresa
     */
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

       /**
     * .
     * Elimina una empresa de los antecedentes de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id
     */

    public function ocupacional_antecedentes_destroy($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $Antecedente_ocupacional = Antecedente_ocupacional::find($antecedente_ocupacional_id);
        $Antecedente_ocupacional->delete();
        flash('La empresa '.$Antecedente_ocupacional->empresa.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.antecedentes',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }
    /**
     * .
     * Muestra los factores de riesgos de los antecedentes de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id
     */
    public function ocupacional_antecedentes_riesgos($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
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
    /**
     * .
     * Registra un factor de riesgo a los antecedentes de la historia ocupacional seleccionada
     * @param $request con los datos del factor de riesgo
     */
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
   /**
     * .
     * Elimna un factor de riesgo de los antecedentes de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_antecedentes_destroy_riesgo($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id,$antecedente_ocupacional_factor_riesgo_id)
    {
        $Antecedente_ocupacional_factor_riesgo = Antecedente_ocupacional_factor_riesgo::find($antecedente_ocupacional_factor_riesgo_id);
        $Antecedente_ocupacional_factor_riesgo->delete();
        flash('La información se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.antecedentes.riesgos',[$paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id]);
    }
    /**
     * .
     * Muestra las lesiones de los antecedentes de la historia ocupacional seleccionada
     * @param $request con los datos de lesión
     */
    public function ocupacional_antecedentes_lesiones($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
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
   /**
     * .
     * Registra una lesion a los antecedentes de la historia ocupacional seleccionada
     * @param $request con los datos de lesión
     */
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
       /**
     * .
     * Elimna una lesion de los antecedentes de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_antecedentes_destroy_lesion($paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id,$tramatologico_id)
    {
        $Traumatologico = Traumatologico::find($tramatologico_id);
        $Traumatologico->delete();
        flash('La información se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.antecedentes.lesiones',[$paciente_id,$historia_ocupacional_id,$antecedente_ocupacional_id]);
    }

     //PATOLOGIAS

     /**
     * .
     * Muestra los datos de patologías de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_patologias($paciente_id,$historia_ocupacional_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $combos=array();
        $tiempo_fumadores = Tiempo_fumador::all()->sortBy('id')->pluck('descripcion','id');
        $cantidad_fumadores = Cantidad_fumador::all()->sortBy('id')->pluck('descripcion','id');
        $tiempo_licores = Tiempo_licor::where('tipo','<>','Exbebedor')->pluck('descripcion','id');
        $tiempo_licores2 = Tiempo_licor::where('tipo','<>','Si')->pluck('descripcion','id');
        $regularidad_medicamentos = Regularidad_medicamento::all()->sortBy('id')->pluck('descripcion','id');
        $enfermedades = Enfermedad::all()->sortBy('descripcion')->pluck('descripcion','id');
        $combos=['enfermedades' => $enfermedades,'tiempo_fumadores' => $tiempo_fumadores,'cantidad_fumadores' => $cantidad_fumadores,'tiempo_licores' => $tiempo_licores,'tiempo_licores2' => $tiempo_licores2,'regularidad_medicamentos' => $regularidad_medicamentos];

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
            $tipolicor=$Habito_licor->tipolicor;
            if($Habito_licor->descripcion=='Si'){
                $tiempo_licor_id=$Habito_licor->tiempo_licor_id;
                $tiempo_licor2_id=1;

            }elseif($Habito_licor->descripcion=='Exbebedor'){

                $tiempo_licor_id=1;
                $tiempo_licor2_id=$Habito_licor->tiempo_licor_id;

            }else{
                $tiempo_licor_id=1;
                $tiempo_licor2_id=1;
            }
            
        }else{

            $bebedor='No';
            $tiempo_licor_id=1;
            $tiempo_licor2_id=1;
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
        $datos=['enfermedades'=>$enfermedades,'inmunizaciones'=>$inmunizaciones,'fumador'=> $fumador, 'tiempo_fumador_id'=> $tiempo_fumador_id, 'cantidad_fumador_id'=> $cantidad_fumador_id, 'nombremedicamento'=> $nombremedicamento, 'regularidad_medicamento_id'=> $regularidad_medicamento_id, 'medicamento'=> $medicamento, 'bebedor'=> $bebedor, 'tiempo_licor_id'=> $tiempo_licor_id, 'tiempo_licor2_id'=> $tiempo_licor2_id, 'tipolicor'=> $tipolicor, 'fum' => $fum, 'fuc' => $fuc, 'citologia' => $citologia, 'dismenorrea' => $dismenorrea, 'gravidez' => $gravidez, 'partos' => $partos, 'cesarias' => $cesarias,'abortos'=>$abortos];

        return  view('historias.historia.ocupacional.patologias')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos,'datos'=>$datos ]);
    }

     /**
     * .
     * Actualiza los datos de habitos de la historia ocupacional seleccionada
     * @param $request con los datos de habitos
     */
    public function Ocupacional_patologias_store_habitos(Request $request)
    {
          $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
      
         
        $validator = Validator::make($request->all(), [
            'fumador' => 'required|string|max:10', 
            'tiempo_fumador_id' => 'required|exists:tiempo_fumadores,id', 
            'cantidad_fumador_id' => 'required|exists:cantidad_fumadores,id', 

            'bebedor' => 'required|string|max:10', 
            'tiempo_licor_id' => 'required|exists:tiempo_licores,id', 
            'tiempo_licor2_id' => 'required|exists:tiempo_licores,id', 
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

            if($request->tiempo_licor_id==1 && $request->tiempo_licor2_id==1)
            {
                $tiempo_licor_id=1;

            }elseif($request->tiempo_licor_id==1){
                $tiempo_licor_id=$request->tiempo_licor2_id;

            }else{
                $tiempo_licor_id=$request->tiempo_licor_id;

            }
            $Habito_licor->tiempo_licor()->associate($tiempo_licor_id);
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
   
     /**
     * .
     * Registra vacunas de la historia ocupacional seleccionada
     * @param $request con los datos de vacunas
     */
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

    /**
     * .
     * Registra efermedades de la historia ocupacional seleccionada
     * @param $request con los datos de efermedad
     */
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

    /**
     * .
     * Actualiza los datos de ginecobstetrica de la historia ocupacional seleccionada
     * @param $request con los datos de ginecobstetrica
     */
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

     /**
     * .
     * Elimina una efermedad de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$patologico_id
     */
    public function Ocupacional_patologias_destroy_enfermedad($paciente_id,$historia_ocupacional_id,$patologico_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $Patologico = Patologico::find($patologico_id);
        $Patologico->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
    }

    /**
     * .
     * Elimina una vacuna de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$inmunizacion_id
     */
    public function Ocupacional_patologias_destroy_vacuna($paciente_id,$historia_ocupacional_id,$inmunizacion_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $Inmunizacion = Inmunizacion::find($inmunizacion_id);
        $Inmunizacion->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
         return redirect()->route('historias.ocupacional.patologias',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
    }

     //EXAMENES FISICOS
      /**
     * .
     * Muestra los datos de los examenes fisicos, ocupacionales y visuales de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_fisicos($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
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
        $exploraciones = Exploracion::where(['historia_ocupacional_id' => $historia_ocupacional->id ])->with('organo.tipo_organo')->orderby('id')->get();
        $visuales = Visual::where(['historia_ocupacional_id' => $historia_ocupacional->id ])->with('examen_visual.tipo_examen_visual')->with('examen_visual.ojo')->orderby('id')->get();
        $datos=[ 'visuales' => $visuales, 'exploraciones' => $exploraciones,'lateralidad_id'=>$lateralidad_id, 'peso'=>$peso, 'talla'=>$talla, 'imc'=>$imc, 'ta'=>$ta, 'fc'=>$fc, 'fr'=>$fr];
        $combos=array();
        $lateralidades = Lateralidad::all()->sortBy('descripcion')->pluck('descripcion','id')->prepend('N/A', 1);
        $organos=array();
        $tipo_organos_query = Tipo_organo::orderby('id')->get();      
        foreach ($tipo_organos_query as $tipo_organo) {
            $organos_query = Organo::where('tipo_organo_id',$tipo_organo->id)->orderby('descripcion')->get();
            foreach ($organos_query as $organo) {
                
                $organos[$organo->id]= $tipo_organo->descripcion.' > '.$organo->descripcion;
            }
        }
        $examen_visuales=array();
        $Examen_visuales_query = Examen_visual::orderby('id')->with('tipo_examen_visual')->with('ojo')->get();
        foreach ($Examen_visuales_query as $examen_visual) {
            if($examen_visual->ojo_id == 3){
                $ambos='Ojos';
                $ojo='';
            }else{
                $ambos='';
                $ojo='Ojo';
            }
            $examen_visuales[$examen_visual->id]= $examen_visual->tipo_examen_visual->descripcion.' > '.$ojo.' '.$examen_visual->ojo->descripcion.' '.$ambos;
        }
      
        $combos=[ 'lateralidades' => $lateralidades,'organos' => $organos,'examen_visuales'=>$examen_visuales];
        return  view('historias.historia.ocupacional.fisicos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=> $combos, 'datos' =>  $datos]);
    }
    /**
     * .
     * Actualiza los datos del examen fisico de la historia ocupacional seleccionada
     * @param $request con los datos del examen fisico
     */
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
     /**
     * .
     * Registra un examen ocupacional de la historia ocupacional seleccionada
     * @param $request con los datos del examen ocupacional
     */
    public function ocupacional_fisicos_store_exploracion(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();

        $validator = Validator::make($request->all(), [
            'organo_id' => 'required|exists:organos,id', 
            'resultado' => 'string|max:250', 
        ]); 
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->id,$historia_ocupacional->id])->withInput();
        }else{
       
            $Exploracion= new Exploracion;
            $Exploracion->resultado=$request->resultado;
            $Exploracion->historia_ocupacional()->associate($historia_ocupacional);
            $Exploracion->organo()->associate($request->organo_id);
            $Exploracion->save();
            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->id,$historia_ocupacional->id]);
        }
    }
    /**
     * .
     * Elimina un examen ocupacional de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$exploracion_id
     */
    public function ocupacional_fisicos_destroy_exploracion($paciente_id,$historia_ocupacional_id,$exploracion_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $Exploracion = Exploracion::find($exploracion_id);
        $Exploracion->delete();
        flash('Los datos se han eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }
    /**
     * .
     * Registra un examen visual de la historia ocupacional seleccionada
     * @param $request con los datos del examen visual
     */
     public function ocupacional_fisicos_store_visual(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
         $validator = Validator::make($request->all(), [
            'examen_visual_id' => 'required|exists:organos,id', 
            'descripcion' => 'string|max:250', 
        ]); 
        
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->id,$historia_ocupacional->id])->withInput();
        }else{
      
            $Visual= new Visual;
            $Visual->descripcion=$request->descripcion;
            $Visual->historia_ocupacional()->associate($historia_ocupacional);
            $Visual->examen_visual()->associate($request->examen_visual_id);
            $Visual->save();
                 
            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->id,$historia_ocupacional->id]);
        }
    }
    /**
     * .
     * Elimina un examen visual de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$visual_id
     */
    public function ocupacional_fisicos_destroy_visual($paciente_id,$historia_ocupacional_id,$visual_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $Visual = Visual::find($visual_id);
        $Visual->delete();
        flash('Los datos se han eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.fisicos',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }

    //ALTURAS
    /**
     * .
     * Muestra la condición del examen de altura de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_alturas($paciente_id,$historia_ocupacional_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();
        $combos=array();
        $tipo_examen_alturas = Tipo_examen_altura::orderby('id')->pluck('descripcion','id');
        $examen_alturas= Examen_altura::where(['historia_ocupacional_id' => $historia_ocupacional->id])->with('tipo_examen_altura')->orderBy('id')->get();

        $tipo_condiciones= Tipo_condicion::where(['tipo_examen_id' =>6 ])->orderBy('id')->pluck('descripcion','id')->prepend('N/A','1');

        $Condicion_altura = Condicion_altura::where(['historia_ocupacional_id' => $historia_ocupacional->id])->first();
        if(!is_null($Condicion_altura))
        {
            $tipo_condicion_id=$Condicion_altura->tipo_condicion_id;
            $observacion=$Condicion_altura->observacion;
            
        }else{
            $tipo_condicion_id=1;
            $observacion='';
        }
        $combos=[ 'tipo_condicion_id' => $tipo_condicion_id, 'observacion' => $observacion,'tipo_examen_alturas' => $tipo_examen_alturas,'examen_alturas'=>$examen_alturas, 'tipo_condiciones'=>$tipo_condiciones];

        return  view('historias.historia.ocupacional.alturas')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos ]);
    }

     /**
     * .
     * Actualiza la condición del examen de altura de la historia ocupacional seleccionada
     * @param $request de la condición del examen de altura
     */
    public function ocupacional_alturas_store_condicion(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();

        $validator = Validator::make($request->all(), [
            'tipo_condicion_id' => 'required|exists:tipo_condiciones,id|not_in:1', 
            'observacion' => 'string|max:500',  
        ]);

        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.alturas',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{

             $Condicion_altura = Condicion_altura::where(['historia_ocupacional_id' => $historia_ocupacional->id])->first();
            if(is_null($Condicion_altura))
            {
                $Condicion_altura=new Condicion_altura;
            }
            $Condicion_altura->tipo_condicion()->associate($request->tipo_condicion_id);
            $Condicion_altura->observacion= $request->observacion;
            $Condicion_altura->historia_ocupacional()->associate($historia_ocupacional);
            $Condicion_altura->save();

            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.alturas',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }
    /**
     * .
     * Registra un examen de altura de la historia ocupacional seleccionada
     * @param $request del examen de altura
     */
    public function ocupacional_alturas_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();


        $validator = Validator::make($request->all(), [
            'tipo_examen_altura_id' => 'required|exists:tipo_examen_alturas,id',   
            'observacion' => 'string|max:500', 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.alturas',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{
            
            $Examen_altura=new Examen_altura;
            $Examen_altura->tipo_examen_altura()->associate($request->tipo_examen_altura_id);
            $Examen_altura->historia_ocupacional()->associate($historia_ocupacional);
            $Examen_altura->observacion=$request->observacion;
            $Examen_altura->save();
            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.alturas',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }
     /**
     * .
     * Elimina un examen de altura de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$examen_altura_id
     */
    public function ocupacional_alturas_destroy($paciente_id,$historia_ocupacional_id,$examen_altura_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $Examen_altura = Examen_altura::find($examen_altura_id);
        $Examen_altura->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.alturas',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }

    //EXAMENES DE LABORATORIO
      /**
     * .
     * Muestra los examenes de laboratorio de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_examenes($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id] )->with('medico_paciente')->first();
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();
        $examen_laboratorios= Examen_laboratorio::where(['historia_ocupacional_id' => $historia_ocupacional->id])->orderBy('id')->get();
        $combos=['examen_laboratorios'=>$examen_laboratorios];
        return  view('historias.historia.ocupacional.examenes')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos' => $combos]);
    }
    
     /**
     * .
     * Registra un examen de laboratorio de la historia ocupacional seleccionada
     * @param $request de los datos del examen de laboratorio
     */
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
    /**
     * .
     * Elimina un examen de laboratorio de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$examen_laboratorio_id
     */
    public function ocupacional_examenes_destroy($paciente_id,$historia_ocupacional_id,$examen_laboratorio_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $Examen_laboratorio = Examen_laboratorio::find($examen_laboratorio_id);
        $Examen_laboratorio->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.examenes',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }

     //DIAGNOSTICOS
     /**
     * .
     * Muestra los datos del diagnostico de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id
     */
    public function ocupacional_diagnosticos($paciente_id,$historia_ocupacional_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        $combos=array();
        $tipo_diagnosticos=array();
        $tipo_diagnosticos_query = Tipo_diagnostico::orderby('codigo')->get();
        foreach ($tipo_diagnosticos_query as $tipo_diagnostico) {
            $tipo_diagnosticos[$tipo_diagnostico->id]=$tipo_diagnostico->codigo.' > '.$tipo_diagnostico->descripcion;
        }
        $diagnosticos= Diagnostico::where(['historia_ocupacional_id' => $historia_ocupacional->id])->with('tipo_diagnostico')->orderBy('id')->get();

        $tipo_condiciones= Tipo_condicion::where(['tipo_examen_id' => $historia_ocupacional->tipo_examen_id])->orderBy('id')->pluck('descripcion','id')->prepend('N/A','1');

        $Condicion_diagnostico = Condicion_diagnostico::where(['historia_ocupacional_id' => $historia_ocupacional->id])->first();
        if(!is_null($Condicion_diagnostico))
        {
            $observacion=$Condicion_diagnostico->observacion;
            $tipo_condicion_id=$Condicion_diagnostico->tipo_condicion_id;
        }else{
            $tipo_condicion_id=1;
            $observacion='';
        }
        $combos=[ 'tipo_condicion_id'=>$tipo_condicion_id, 'observacion' => $observacion,'tipo_diagnosticos' => $tipo_diagnosticos,'diagnosticos'=>$diagnosticos,'tipo_condiciones'=> $tipo_condiciones];

        return  view('historias.historia.ocupacional.diagnosticos')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional,'combos'=>$combos ]);
    }
     /**
     * .
     * Actualiza los datos la condición del diagnostico de la historia ocupacional seleccionada
     * @param $Request los datos del diagnostico
     */
    public function ocupacional_diagnosticos_store_condicion(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
        $validator = Validator::make($request->all(), [
            'tipo_condicion_id' => 'required|exists:tipo_condiciones,id|not_in:1', 
            'observacion' => 'string|max:500',  
        ]);

        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.diagnosticos',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{

             $Condicion_diagnostico = Condicion_diagnostico::where(['historia_ocupacional_id' => $historia_ocupacional->id])->first();
            if(is_null($Condicion_diagnostico))
            {
                $Condicion_diagnostico=new Condicion_diagnostico;
            }
            $Condicion_diagnostico->tipo_condicion()->associate($request->tipo_condicion_id); 
            $Condicion_diagnostico->observacion= $request->observacion;
            $Condicion_diagnostico->historia_ocupacional()->associate($historia_ocupacional);
            $Condicion_diagnostico->save();

            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.diagnosticos',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);
        }
    }

     /**
     * .
     * Registra los datos del diagnostico individual de la historia ocupacional seleccionada
     * @param $request los datos del diagnostico individual
     */
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
    /**
     * .
     * Elimina un diagnostico individual de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$diagnostico_id
     */
    public function ocupacional_diagnosticos_destroy($paciente_id,$historia_ocupacional_id,$diagnostico_id)
    {
         $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $Diagnostico = Diagnostico::find($diagnostico_id);
        $Diagnostico->delete();
        flash('El registro se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('historias.ocupacional.diagnosticos',[$historia_ocupacional->medico_paciente->paciente->id,$historia_ocupacional->id]);

    }

    //RECOMENDACIONES
    /**
     * .
     * Muestra las recomendaciones de la historia ocupacional seleccionada
     * @param $paciente_id,$historia_ocupacional_id,$diagnostico_id
     */
    public function ocupacional_recomendaciones($paciente_id,$historia_ocupacional_id)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id,'activa'=>1] )->with('medico_paciente')->first();
        if(is_null($historia_ocupacional)){
            abort(404);
        }
        $paciente = Paciente::where(['id'=> $historia_ocupacional->medico_paciente->paciente_id])->with('user')->first();
        $medico = Medico::where(['id'=> $historia_ocupacional->medico_paciente->medico_id])->with('user')->first();

        return  view('historias.historia.ocupacional.recomendaciones')->with(['paciente'=>$paciente,'medico'=>$medico,'historia_ocupacional'=>$historia_ocupacional ]);
    }

    /**
     * .
     * Actualiza las recomendaciones de la historia ocupacional seleccionada
     * @param $request con la recomedación
     */
    public function ocupacional_recomendaciones_store(Request $request)
    {
        $historia_ocupacional = Historia_ocupacional::where(['id' => $request->historia_ocupacional_id] )->with('medico_paciente')->first();
        $validator = Validator::make($request->all(), [
            'recomendaciones' => 'string|max:2500',   
            
        ]);

         if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('historias.ocupacional.recomendaciones',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id])->withInput();
        }else{

            $historia_ocupacional->recomendaciones=$request->recomendaciones;
            $historia_ocupacional->save();
            flash('Se ha registrado la información de forma exitosa!', 'success');
            return redirect()->route('historias.ocupacional.recomendaciones',[$historia_ocupacional->medico_paciente->paciente_id,$historia_ocupacional->id]);

       }
    }

}
