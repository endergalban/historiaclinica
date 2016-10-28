<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use App\Modulo;
use App\Role;

class ModulosController extends Controller
{
    public function index(Request $request){

    	$modulos= Modulo::ofType($request->search)->with('roles')->orderBy('orden','asc')->paginate(15);
    	return view('modulos.index')->with(['modulos' => $modulos]);
    }

    public function create(){
      
    	$roles= Role::all()->sortBy('descripcion')->pluck('descripcion','id');
    	return view('modulos.create')->with(['roles'=> $roles]);
    }

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
           
            'orden' => 'required|integer',     
            'icono' => 'required|string|min:4',
            'descripcion' => 'required|string|max:50',          
            'site' => 'required|string|max:50',         
           
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('modulos.create')->withInput();
        }

   
        $modulo= new Modulo;
        $modulo->orden         = $request->orden;          
        $modulo->icono         = $request->icono;
        $modulo->descripcion   = $request->descripcion;
        $modulo->site          = $request->site;
        $modulo->save();
        foreach($request->roles as $role){

            $currentrole = Role::where(['id'=>$role])->first();
            if($currentrole){
                $modulo->roles()->attach($currentrole);
            }
        }
       
        flash('Se ha registrado el módulo '.$modulo->descripcion.' de forma exitosa!', 'success');
        return redirect()->route('modulos.index');
    }

    public function edit($id){
      
    	$modulo= Modulo::findOrFail($id);
    	$roles= Role::all()->sortBy('descripcion')->pluck('descripcion','id');
    	$modulo_role=Modulo::find($modulo->id)->roles()->pluck('role_id')->toArray();
    	return view('modulos.edit')->with(['modulo' => $modulo,'roles'=> $roles,'modulo_role'=>$modulo_role]);
    }

    public function update(Request $request, $id)
    {
        $modulo  =   Modulo::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'registro' => 'required|string|max:100',     
        ]);
       	$validator = Validator::make($request->all(), [
           
            'orden' => 'required|integer',     
            'icono' => 'required|string|min:4',
            'descripcion' => 'required|string|max:50',          
            'site' => 'required|string|max:50',         
           
        ]);

       	$modulo->orden         = $request->orden;          
        $modulo->icono         = $request->icono;
        $modulo->descripcion   = $request->descripcion;
        $modulo->site          = $request->site;
        $modulo->save();
        $modulo->roles()->detach();
        foreach($request->roles as $role){

            $currentrol = Role::where(['id'=>$role])->first();
            if($currentrol){
                $modulo->roles()->attach($currentrol);
            }
        }
        
        flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('modulos.index');
       
    }

    public function destroy($id){

    	$modulo= Modulo::finOrFail($id);
    	$modulo->delete();
    	flash('El modulo '.$modulo->descipcion.' se ha eliminado de forma exitosa!', 'danger');
    	return view('modulos.index')->with(['modulos' => $modulos]);
    }
}
