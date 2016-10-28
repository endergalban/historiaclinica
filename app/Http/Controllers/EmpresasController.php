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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        $empresas=Empresa::ofType($request->search)->orderby('descripcion','ASC')->paginate(15);
        return  view('empresas.index')->with(['empresas'=>$empresas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return  view('empresas.create');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $empresa=Empresa::findOrFail($id);
       return  view('empresas.edit')->with('empresa',$empresa);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa=Empresa::findOrFail($id);
        $empresa->delete();
        flash('La EPS '.$empresa->descripcion.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('empresas.index');
    }
}
