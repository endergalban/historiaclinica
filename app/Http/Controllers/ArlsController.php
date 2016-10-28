<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use App\Arl;

class ArlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        $arls=Arl::ofType($request->search)->orderby('descripcion','ASC')->paginate(15);
        return  view('arls.index')->with(['arls'=>$arls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return  view('arls.create');
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
            'descripcion' => 'required|string|max:100|unique:arls,descripcion', 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('arls.create')->withInput();
        }

        $arl= new Arl;
        $arl->descripcion            = $request->descripcion;
        $arl->save();

        flash('Se ha registrado la arl '.$arl->descripcion.' de forma exitosa!', 'success');
        return redirect()->route('arls.index');
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
       $arl=Arl::findOrFail($id);
       return  view('arls.edit')->with('arl',$arl);
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
        $arl=Arl::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:100',Rule::unique('descripcion')->ignore($arl->id), 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('arls.edit',$arl)->withInput();
        }
        $arl->descripcion = $request->descripcion;
        $arl->save();

        flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('arls.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $arl=Arl::findOrFail($id);
        $arl->delete();
        flash('La ARL '.$arl->descripcion.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('arls.index');
    }
}
