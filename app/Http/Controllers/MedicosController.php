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
use App\Especialidad;

class MedicosController extends Controller
{
    /**
     * .
     * Muestra los asistentes del sistema
     * @param  $request->search  para filtro de resultado
     */
    public function index(Request $request)
    {
        $users=User::ofType($request->search)->has('medico')->orderby('numerodocumento','ASC')->paginate(15);
        return  view('medicos.index')->with(['users'=>$users ]);
    }

    /**
     * .
     * Configura el formulario para la creación de asistente
     * 
     */
    public function create()
    {
        $especialidades=Especialidad::all()->sortBy('descripcion')->pluck('descripcion', 'id')->prepend('');
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
        return  view('medicos.create')->with(['nacimiento' => $nacimiento ,'especialidades' => $especialidades]);
    }

     /**
     * .
     *  Registra un medico en el sistema
     *  @param  $request con los datos del medico
     */
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
            'registro' => 'required|string|max:100',
            'foto' => 'image', 
            'banner' => 'image', 
         
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('medicos.create')->withInput();
        }
        $municipio_id = Municipio::where(['id'=>$request->municipio_id])->first();
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
        $currentrole = Role::where(['id'=>2])->first();
        $user->roles()->attach($currentrole);
       

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
		$medico = new Medico;
		$medico->user()->associate($user);
        $medico->registro = $request->registro;
        $medico->banner = '';
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
            $imagebanner = $user->id . '.' . $request->file('banner')->getClientOriginalExtension();
            Image::make($request->file('banner'))->resize(null, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/banner/'.$imagebanner);
            $medico->banner=$imagebanner;
            $medico->save();
        }
        
        flash('Se ha registrado '.$user->primernombre.' '.$user->primerapellido.' de forma exitosa!', 'success');
        return redirect()->route('medicos.index');
    }

     /**
     * .
     * Muestra los datos de un medico en el sistema
     *  @param  $id del medico
     */
    public function show($id)
    {
        $user=User::with('municipio.departamento.pais')->with('medico')->where('id',$id)->first();
        $paises=Pais::all()->pluck('descripcion', 'id');
         //Nacimiento
        $departamentos=Departamento::where('pais_id',$user->municipio->departamento->pais->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        $municipios=Municipio::where('departamento_id',$user->municipio->departamento->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
         $especialidades=Especialidad::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $especialidad_medico=Medico::find($user->medico->id)->especialidades()->pluck('especialidad_id')->toArray();

        return  view('medicos.show')->with(['user' => $user,'paises' => $paises,'departamentos' => $departamentos,'municipios' => $municipios,'especialidades' => $especialidades,'especialidad_medico' => $especialidad_medico ]);
    }

    /**
     * .
     * Muestra los datos de un medico en el sistema para su edición
     *  @param  $id del medico
     */
    public function edit($id)
    {
        $user=User::with('municipio.departamento.pais')->with('medico')->where('id',$id)->first();
        $paises=Pais::all()->pluck('descripcion', 'id');
        $departamentos=Departamento::where('pais_id',$user->municipio->departamento->pais->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        $municipios=Municipio::where('departamento_id',$user->municipio->departamento->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        $especialidades=Especialidad::all()->sortBy('descripcion')->pluck('descripcion', 'id');

        $especialidad_medico=Medico::find($user->medico->id)->especialidades()->pluck('especialidad_id')->toArray();

        return  view('medicos.edit')->with(['user' => $user,'paises' => $paises,'departamentos' => $departamentos,'municipios' => $municipios,'especialidades' => $especialidades,'especialidad_medico'=>$especialidad_medico ]);
    }

     /**
     * .
     * Edita los datos de un medico 
     *  @param  $request con los datos del medico 
     */
    public function update(Request $request, $id)
    {
        $user   =   User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'imagen' => 'image', 
            'tipodocumento' => 'required|string|max:2',     
            'numerodocumento' => 'required|string|max:12',Rule::unique('users')->ignore($user->numerodocumento),
            'email' => 'required|email',Rule::unique('users')->ignore($user->email), 
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
            'registro' => 'required|string|max:100',
            'foto' => 'image', 
            'banner' => 'image', 
         
        ]);
        if ($validator->fails()) {
          flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('medicos.edit',$user->id);
        }
        $municipio_id = Municipio::where(['id'=>$request->municipio_id])->first();
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
        $medico  =   Medico::where('user_id',$user->id)->first();
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
        return redirect()->route('medicos.index');
    }

   /**
     * .
     * Elimina un medico 
     *  @param  $id del medico 
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash('El paciente '.$user->primernombre.' '.$user->primerapellido.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('medicos.index');
    }
}
