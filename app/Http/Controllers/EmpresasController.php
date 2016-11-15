<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use App\Empresa;

class EmpresasController extends Controller
{
     /**
     * .
     * Muestra las eps del sistema
     * @param  $request->search  para filtro de resultado
     */
     public function index(Request $request)
    {
        $empresas=Empresa::ofType($request->search)->orderby('descripcion','ASC')->paginate(15);
        return  view('empresas.index')->with(['empresas'=>$empresas]);
    }

    /**
     * .
     * Configura el formulario para la creación de la eps
     * 
     */
    public function create()
    {
         return  view('empresas.create');
    }

   /**
     * .
     * Registra los datos de una eps en el sistema
     *  @param $request con los datos de una eps 
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:100|unique:empresas,descripcion', 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('empresas.create')->withInput();
        }

        $empresa= new Empresa;
        $empresa->descripcion            = $request->descripcion;
        $empresa->save();

        flash('Se ha registrado la EPS '.$empresa->descripcion.' de forma exitosa!', 'success');
        return redirect()->route('empresas.index');
    }

    /**
     * .
     * Muestra los datos de una eps en el sistema para su edición
     *  @param  $id de la eps
     */
    public function edit($id)
    {
       $empresa=Empresa::findOrFail($id);
       return  view('empresas.edit')->with('empresa',$empresa);
    }

     /**
     * .
     * Edita los datos de una eps 
     *  @param  $request con los datos de una eps 
     */
    public function update(Request $request, $id)
    {
        $empresa=Empresa::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:100',Rule::unique('descripcion')->ignore($empresa->id), 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('empresas.edit',$empresa)->withInput();
        }
        $empresa->descripcion = $request->descripcion;
        $empresa->save();

        flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('empresas.index');
    }

    /**
     * .
     * Elimina una eps 
     *  @param  $id de la eps 
     */
    public function destroy($id)
    {
        $empresa=Empresa::findOrFail($id);
        $empresa->delete();
        flash('La EPS '.$empresa->descripcion.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('empresas.index');
    }
}
