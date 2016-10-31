<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use Image;
use App\User;
use App\Role;
use App\Pais;
use App\Departamento;
use App\Municipio;
use Carbon\Carbon;
use App\Medico;
use App\Asistente;
use App\Paciente;
use App\Especialidad;
use App\Empresa;
use App\Arl;
use App\Afp;



class UsersController extends Controller
{

    public function index(Request $request)
    {
		$users=User::ofType($request->search)->with('roles')->orderby('numerodocumento','ASC')->paginate(15);
        $roles=Role::all()->pluck('descripcion', 'id');
        return	view('users.index')->with(['users'=>$users,'roles'=>$roles]);
    }

    public function create()
    {
       
        $roles=Role::all()->pluck('descripcion', 'id');
        $paises=Pais::all()->sortBy('descripcion')->pluck('descripcion', 'id')->prepend('Seleccione una opción', 0);
        if(old('pais_id'))
        {
            $departamentos=Departamento::where('pais_id',old('pais_id'))->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id')->prepend('Seleccione una opción', 0);
        }else{
            $departamentos=['0'=>'Seleccione una opción'];
        }

        if(old('departamento_id'))
        {
            $municipios=Municipio::where('departamento_id',old('departamento_id'))->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id')->prepend('Seleccione una opción', 0);
        }else{
            $municipios=['0'=>'Seleccione una opción'];
        }
        $nacimiento=['municipios'=> $municipios,'departamentos'=> $departamentos,'paises'=> $paises];
        return	view('users.create')->with(['nacimiento' => $nacimiento ,'roles' => $roles]);

    }

    public function store(Request $request)
    {
        
        
        $validator = Validator::make($request->all(), [
            'imagen' => 'image', 
            'tipodocumento' => 'required|string|max:2',     
            'numerodocumento' => 'required|string|max:12|unique:users,numerodocumento',
            'email' => 'required|email|unique:users,email', 
            'activo' => 'required|boolean',  
            'primernombre' => 'required|string|max:50',          
            'segundonombre' => 'string|max:50',         
            'primerapellido' => 'required|string|max:50',        
            'segundoapellido' => 'string|max:50',  
            'genero'  => 'required|string|max:10',      
            'fechanacimiento' => 'required|date_format:d/m/Y',       
            'estadocivil' => 'required|string|max:20', 
            'ocupacion' => 'string|max:100',             
            'pais_id' => 'exists:paises,id',           
            'departamento_id' => 'exists:departamentos,id',
            'municipio_id' => 'exists:municipios,id',
            'telefono' => 'required|string|max:13',   
            'direccion' => 'string|max:255',
            'foto' => 'image', 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('users.create')->withInput();
        }


        $municipio_id = Municipio::where(['id'=>$request->municipio_id])->first();
        $municipioresidencia_id = Municipio::where(['id'=>$request->municipio_id])->first();

        $user= new User;
        $user->email                  = $request->email;
        $user->password               = bcrypt('123456');
        $user->tipodocumento          = $request->tipodocumento;          
        $user->numerodocumento        = $request->numerodocumento;
        $user->primernombre           = $request->primernombre;
        $user->segundonombre          = $request->segundonombre;
        $user->primerapellido         = $request->primerapellido;
        $user->segundoapellido        = $request->segundoapellido;
        $user->fechanacimiento        = Carbon::createFromFormat('d/m/Y',$request->fechanacimiento);
        $user->genero                 = $request->genero;
        $user->estadocivil            = $request->estadocivil;
        $user->municipio()->associate($municipio_id);
        $user->direccion              = $request->direccion;
        $user->ocupacion              = $request->ocupacion;
        $user->telefono               = $request->telefono;
        $user->activo                 = $request->activo;
        $user->save();
        if($request->roles){
            foreach($request->roles as $role){

                $currentrole = Role::where(['id'=>$role])->first();
                if($currentrole){

                    $user->roles()->attach($currentrole);
                    if($currentrole->id == 2){ //medico
                        if(Medico::where('user_id',$user->id)->count() == 0){
                            $medico = new Medico;
                            $medico->user()->associate($user);
                            $medico->registro = '';
                            $medico->banner = '';
                            $medico->save();
                        }
                    }
                    if($currentrole->id == 3){//asistente
                        if(Asistente::where('user_id',$user->id)->count() == 0){
                            $asistente = new Asistente;
                            $asistente->user()->associate($user);
                            $asistente->save();
                        }
                    }
                    if($currentrole->id == 4){//paciente
                        if(Paciente::where('user_id',$user->id)->count() == 0){
                            $paciente = new Paciente;
                            $paciente->user()->associate($user);
                            $paciente->empresa_id=0;
                            $paciente->municipio_id=0;
                            $paciente->save();
                        }
                    }
                }
            }
        }
        if( $request->hasFile('imagen')){ 
            $imageName = $user->id . '.' . $request->file('imagen')->getClientOriginalExtension();
            Image::make($request->file('imagen'))->resize(null, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/users/'.$imageName);
            $user->imagen=$imageName;
            $user->save();
        }

        if( $request->hasFile('firma')){ 
            $imagefirma = $user->id . '.' . $request->file('firma')->getClientOriginalExtension();
            Image::make($request->file('firma'))->resize(null, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/firmas/'.$imagefirma);
            $user->firma=$imagefirma;
            $user->save();
        }


        flash('Se ha registrado '.$user->primernombre.' '.$user->primerapellido.' de forma exitosa!', 'success');
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user=User::with('municipio.departamento.pais')->where('id',$id)->first();
        $paises=Pais::all()->sortBy('descripcion')->pluck('descripcion', 'id');
         //Nacimiento
        $departamentos=Departamento::where('pais_id',$user->municipio->departamento->pais->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        $municipios=Municipio::where('departamento_id',$user->municipio->departamento->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
              

        return  view('users.show')->with(['user' => $user,'paises' => $paises,'departamentos' => $departamentos,'municipios' => $municipios ]);
    }

    public function edit($id)
    {
        $user=User::with('municipio.departamento.pais')->where('id',$id)->first();
        
        $roles=Role::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $user_role = User::find($id)->roles()->pluck('role_id')->toArray();
      
        $paises=Pais::all()->sortBy('descripcion')->pluck('descripcion', 'id');
         //Nacimiento
        $departamentos=Departamento::where('pais_id',$user->municipio->departamento->pais->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        $municipios=Municipio::where('departamento_id',$user->municipio->departamento->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        return	view('users.edit')->with(['user' => $user,'paises' => $paises,'departamentos' => $departamentos,'municipios' => $municipios,'roles' => $roles,'user_role' =>  $user_role ]);
    }

    public function password($id)
    {
		$user	=	User::findOrFail($id);
		$user->password = bcrypt('123456');
		$user->save();
		flash('El password del usuario '.$user->primernombre.' '.$user->primerapellido.' ha sido restablecido de forma exitosa (132456)!', 'success');
        return redirect()->route('users.index');
    }

    public function estatus($id)
    {
		$user	=	User::findOrFail($id);
		if($user->activo == true){
			$user->activo = false;
		}else{
			$user->activo = true;
		}
		$user->save();
		flash('El estatus del usuario '.$user->primernombre.' '.$user->primerapellido.' ha cambiado de forma exitosa!', 'success');
        return redirect()->route('users.index');
    }

    public function update(Request $request, $id)
    {
		 $user	=	User::findOrFail($id);
         $validator = Validator::make($request->all(), [
            'imagen' => 'image', 
            'tipodocumento' => 'required|string|max:2',     
            'numerodocumento' => 'required|string|max:12',Rule::unique('users')->ignore($user->numerodocumento),
            'email' => 'required|email|',Rule::unique('users')->ignore($user->email), 
            'activo' => 'required|boolean',  
            'primernombre' => 'required|string|max:50',          
            'segundonombre' => 'string|max:50',         
            'primerapellido' => 'required|string|max:50',        
            'segundoapellido' => 'string|max:50',  
            'genero'  => 'required|string|max:10',      
            'fechanacimiento' => 'required|date_format:d/m/Y',       
            'estadocivil' => 'required|string|max:20', 
            'ocupacion' => 'string|max:100',             
            'pais_id' => 'exists:paises,id',           
            'departamento_id' => 'exists:departamentos,id',
            'municipio_id' => 'exists:municipios,id',
            'telefono' => 'required|string|max:13',   
            'direccion' => 'string|max:255',   
            'firma' => 'image',              


        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('users.edit',$user->id);
        }

        $municipio_id = Municipio::where(['id'=>$request->municipio_id])->first();
        $municipioresidencia_id = Municipio::where(['id'=>$request->municipioresidencia_id])->first();

		$user->email                  = $request->email;
        $user->tipodocumento          = $request->tipodocumento;          
        $user->numerodocumento        = $request->numerodocumento;
        $user->primernombre           = $request->primernombre;
        $user->segundonombre          = $request->segundonombre;
        $user->primerapellido         = $request->primerapellido;
        $user->segundoapellido        = $request->segundoapellido;
        $user->fechanacimiento        = Carbon::createFromFormat('d/m/Y',$request->fechanacimiento);
        $user->genero                 = $request->genero;
        $user->estadocivil            = $request->estadocivil;
        $user->municipio()->associate($municipio_id);
        $user->direccion              = $request->direccion;
        $user->ocupacion              = $request->ocupacion;
        $user->telefono               = $request->telefono;
        $user->activo                 = $request->activo;
        $user->save();
        $user->roles()->detach();
        if($request->roles){
            foreach($request->roles as $role){

                $currentrole = Role::where(['id'=>$role])->first();
                if($currentrole){

                    $user->roles()->attach($currentrole);
                    if($currentrole->id == 2){//medico
                        if(Medico::where('user_id',$user->id)->count() == 0){
                            $medico = new Medico;
                            $medico->user()->associate($user);
                            $medico->registro = '';
                            $medico->banner = '';
                            $medico->save();
                        }
                    }
                    if($currentrole->id == 3){//asistente
                        if(Asistente::where('user_id',$user->id)->count() == 0){
                            $asistente = new Asistente;
                            $asistente->user()->associate($user);
                            $asistente->save();
                        }
                    }
                    if($currentrole->id == 4){//paciente
                        if(Paciente::where('user_id',$user->id)->count() == 0){
                            $paciente = new Paciente;
                            $paciente->user()->associate($user);
                            $paciente->municipio_id=0;
                            $paciente->empresa_id=0;
                            $paciente->afp_id=0;
                            $paciente->arl_id=0;
                            $paciente->save();
                        }
                    }
                }
            }
        }
        if( $request->hasFile('imagen')){ 
            $imageName = $user->id . '.' . $request->file('imagen')->getClientOriginalExtension();
            Image::make($request->file('imagen'))->resize(null, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/users/'.$imageName);
            $user->imagen=$imageName;
            $user->save();
        }

        if( $request->hasFile('firma')){ 
            $imagefirma = $user->id . '.' . $request->file('firma')->getClientOriginalExtension();
            Image::make($request->file('firma'))->resize(null, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/firmas/'.$imagefirma);
            $user->firma=$imagefirma;
            $user->save();
        }

		flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('users.index');
    }

    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash('El usuario '.$user->primernombre.' '.$user->primerapellido.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('users.index');
    }

    public function role($id,$rol_id)
    {
        $user = User::findOrFail($id);
        $role = Role::findOrFail($rol_id);
        if($role->id == 1)//ADMINISTRADOR
        {
             return redirect()->route('users.index');

        }elseif($role->id == 2){ // MEDICO

            $especialidades=Especialidad::all()->sortBy('descripcion')->pluck('descripcion', 'id');
            $medico = User::find($id)->medico()->first();
            $especialidad_medico=Medico::find($medico->id)->especialidades()->pluck('especialidad_id')->toArray();
            return  view('users.medico')->with(['medico' => $medico,'especialidades' => $especialidades,'especialidad_medico' => $especialidad_medico ]);

        }elseif($role->id == 3){//ASISTENTE

            $asistente = User::find($id)->asistente()->first();
            $querymedicos=User::has('medico')->orderby('tipodocumento','ASC')->get();

            $medicos=array();
            foreach ($querymedicos as $medico) {
                $medicos[$medico->medico->id]=$medico->tipodocumento.' '.$medico->numerodocumento
                .' '.$medico->primerapellido.' '.$medico->primernombre;
            }

            $asistente_medico=Asistente::find($asistente->id)->medicos()->pluck('medico_id')->toArray();
           
             return  view('users.asistente')->with(['asistente' => $asistente,'medicos' => $medicos,'asistente_medico' => $asistente_medico]);

        }elseif($role->id == 4){// PACIENTE

            $paciente=User::where('id',$id)->with('paciente.municipio.departamento.pais')->first();
            
            $paises=Pais::all()->pluck('descripcion', 'id')->prepend('Seleccione una opción',0); 
            if(isset($paciente->paciente->municipio->departamento->pais->id))
            {
                $departamentos=Departamento::where('pais_id',$paciente->paciente->municipio->departamento->pais->id)->pluck('descripcion', 'id');
                $municipios=Municipio::where('departamento_id',$paciente->paciente->municipio->departamento->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
                $residencia['municipioresidencia_id']=$paciente->paciente->municipio->id;
                $residencia['departamentoresidencia_id']=$paciente->paciente->municipio->departamento->id;
                $residencia['paisresidencia_id']=$paciente->paciente->municipio->departamento->pais->id;

            }else{

                $departamentos=[0=>'Seleccione una opción'];
                $municipios=[0 => 'Seleccione una opción'];
                $residencia['municipioresidencia_id']='0';
                $residencia['departamentoresidencia_id']='0';
                $residencia['paisresidencia_id']='0';
            }

            $empresas=Empresa::all()->sortBy('descripcion')->pluck('descripcion', 'id')->prepend('N/A',0);
            $arls=Arl::all()->sortBy('descripcion')->pluck('descripcion', 'id')->prepend('N/A',0);
            $afps=Afp::all()->sortBy('descripcion')->pluck('descripcion', 'id')->prepend('N/A',0);

            return  view('users.paciente')->with(['paciente' => $paciente,'empresas' => $empresas,'paises' => $paises,'departamentos' => $departamentos,'municipios' => $municipios,'arls' => $arls,'afps' => $afps,'residencia' => $residencia]);
        }

        
    }

    public function medico(Request $request, $id)
    {
        $medico  =   Medico::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'registro' => 'required|string|max:100',     
            'banner' => 'image', 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('users.role',[$medico->user_id,2]);
        }

        $medico->registro = $request->registro;
        $medico->save();
        $medico->especialidades()->detach();
        if($request->especialidades){
            foreach($request->especialidades as $especialidad){

                $currentespecialidad = Especialidad::where(['id'=>$especialidad])->first();
                if($currentespecialidad){
                    $medico->especialidades()->attach($currentespecialidad);
                }
            }
        }
        if( $request->hasFile('banner')){ 
            $imagebanner = $medico->user_id . '.' . $request->file('banner')->getClientOriginalExtension();
            Image::make($request->file('banner'))->resize(null, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/banner/'.$imagebanner);
            $medico->banner=$imagebanner;
            $medico->save();
        }
        
        flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('users.role',[$medico->user_id,2]);
       
    }

     public function asistente(Request $request, $id)
    {
        $asistente  =   Asistente::findOrFail($id);

        $asistente->medicos()->detach();
        if($request->medicos){
            foreach($request->medicos as $medico){

                $current = Medico::where(['id'=>$medico])->first();
                if($current){
                    $asistente->medicos()->attach($current);
                }
            }
        }
       
        
        flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('users.role',[$asistente->user_id,3]);
       
    }


    public function paciente(Request $request, $id)
    {
         $paciente  =   Paciente::findOrFail($id);
         $validator = Validator::make($request->all(), [
           'paisresidencia_id' => 'exists:paises,id',           
            'departamentoresidencia_id' => 'exists:departamentos,id',
            'municipioresidencia_id' => 'exists:municipios,id',
        ]);

       if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
             return redirect()->route('users.role',[$paciente->user_id,4]);
        }
        
        $validator = Validator::make($request->all(), [
            'empresa_id' => 'integer',     
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('users.role',[$paciente->user_id,4]);
        }
        $paciente->municipio_id = $request->municipioresidencia_id;
        $paciente->empresa_id = $request->empresa_id;
        $paciente->arl_id = $request->arl_id;
        $paciente->afp_id = $request->afp_id;
        $paciente->save();
               
        flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('users.role',[$paciente->user_id,4]);
       
    }


}