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

class AsistentesController extends Controller
{
     
    public function index(Request $request)
    {
        $users=User::ofType($request->search)->has('asistente')->orderby('numerodocumento','ASC')->paginate(15);
        return  view('asistentes.index')->with(['users'=>$users ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $paises=Pais::all()->pluck('descripcion', 'id')->prepend('Seleccione una opción', $key = null);
        $querymedicos=User::has('medico')->orderby('tipodocumento','ASC')->get();
        $medicos=array();
        foreach ($querymedicos as $medico) {
            $medicos[$medico->medico->id]=$medico->tipodocumento.' '.$medico->numerodocumento.' '.$medico->primerapellido.' '.$medico->primernombre;
        }
        return  view('asistentes.create')->with(['paises' => $paises ,'medicos' => $medicos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            'foto' => 'image', 
            
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('asistentes.create')->withInput();
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
        $currentrole = Role::where(['id'=>3])->first();
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

        $asistente = new Asistente;
        $asistente->user()->associate($user);
        $asistente->save();

        if($request->medicos){
            foreach($request->medicos as $medico){

                $current = Medico::where(['id'=>$medico])->first();
                if($current){
                    $asistente->medicos()->attach($current);
                }
            }
        }


        flash('Se ha registrado '.$user->primernombre.' '.$user->primerapellido.' de forma exitosa!', 'success');
        return redirect()->route('asistentes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::with('municipio.departamento.pais')->with('asistente')->where('id',$id)->first();
        $paises=Pais::all()->pluck('descripcion', 'id');
         //Nacimiento
        $departamentos=Departamento::where('pais_id',$user->municipio->departamento->pais->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        $municipios=Municipio::where('departamento_id',$user->municipio->departamento->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');

        $querymedicos=User::has('medico')->orderby('tipodocumento','ASC')->get();
        
        $medicos=array();
        foreach ($querymedicos as $medico) {
            $medicos[$medico->medico->id]=$medico->tipodocumento.' '.$medico->numerodocumento.' '.$medico->primerapellido.' '.$medico->primernombre;
        }
        
        $asistente_medico=Asistente::find($user->asistente->id)->medicos()->pluck('medico_id')->toArray();

        return  view('asistentes.show')->with(['user' => $user,'paises' => $paises,'departamentos' => $departamentos,'municipios' => $municipios,'medicos'=>$medicos,'asistente_medico'=>$asistente_medico  ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    


    public function edit($id)
    {
       
        $user=User::with('municipio.departamento.pais')->with('asistente')->where('id',$id)->first();
        $paises=Pais::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $departamentos=Departamento::where('pais_id',$user->municipio->departamento->pais->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        $municipios=Municipio::where('departamento_id',$user->municipio->departamento->id)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
		
		$querymedicos=User::has('medico')->orderby('tipodocumento','ASC')->get();
		
		$medicos=array();
		foreach ($querymedicos as $medico) {
			$medicos[$medico->medico->id]=$medico->tipodocumento.' '.$medico->numerodocumento.' '.$medico->primerapellido.' '.$medico->primernombre;
		}
		
        $asistente_medico=Asistente::find($user->asistente->id)->medicos()->pluck('medico_id')->toArray();
        
        return  view('asistentes.edit')->with(['user' => $user,'paises' => $paises,'departamentos' => $departamentos,'municipios' => $municipios,'medicos'=>$medicos,'asistente_medico'=>$asistente_medico ]);
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
        $user   =   User::findOrFail($id);
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
            'paisresidencia_id' => 'exists:paises,id',           
            'departamentoresidencia_id' => 'exists:departamentos,id',
            'municipioresidencia_id' => 'exists:municipios,id', 
            'telefono' => 'required|string|max:13',   
            'direccion' => 'string|max:255',   
            'firma' => 'image',              


        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('asistentes.edit',$user->id);
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

        $asistente = Asistente::where('user_id',$user->id)->first();
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
        return redirect()->route('asistentes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash('El asistente '.$user->primernombre.' '.$user->primerapellido.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('asistentes.index');
    }
}
