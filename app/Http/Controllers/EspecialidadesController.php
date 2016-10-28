<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use App\Especialidad;

class EspecialidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $especialidades=Especialidad::ofType($request->search)->orderby('descripcion','ASC')->paginate(15);
        return  view('especialidades.index')->with(['especialidades'=>$especialidades]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return  view('especialidades.create');
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
            'descripcion' => 'required|string|max:100|unique:especialidades,descripcion', 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('especialidades.create')->withInput();
        }

        $especialidad= new Especialidad;
        $especialidad->descripcion            = $request->descripcion;
        $especialidad->save();

        flash('Se ha registrado la especialidad '.$especialidad->descripcion.' de forma exitosa!', 'success');
        return redirect()->route('especialidades.index');
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
       $especialidad=Especialidad::findOrFail($id);
       return  view('especialidades.edit')->with('especialidad',$especialidad);
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
        $especialidad=Especialidad::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:100',Rule::unique('descripcion')->ignore($especialidad->id), 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('especialidades.edit',$especialidad)->withInput();
        }
        $especialidad->descripcion = $request->descripcion;
        $especialidad->save();

        flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('especialidades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $especialidad=Especialidad::findOrFail($id);
        $especialidad->delete();
        flash('La especialidad '.$especialidad->descripcion.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('especialidades.index');
    }
}
