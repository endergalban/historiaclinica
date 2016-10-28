<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use App\Afp;	

class AfpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        $afps=Afp::ofType($request->search)->orderby('descripcion','ASC')->paginate(15);
        return  view('afps.index')->with(['afps'=>$afps]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return  view('afps.create');
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
            'descripcion' => 'required|string|max:100|unique:afps,descripcion', 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('afps.create')->withInput();
        }

        $afp= new Afp;
        $afp->descripcion = $request->descripcion;
        $afp->save();

        flash('Se ha registrado la AFP '.$afp->descripcion.' de forma exitosa!', 'success');
        return redirect()->route('afps.index');
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
       $afp=Afp::findOrFail($id);
       return  view('afps.edit')->with('afp',$afp);
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
        $afp=Afp::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:100',Rule::unique('descripcion')->ignore($afp->id), 
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('afps.edit',$afp)->withInput();
        }
        $afp->descripcion = $request->descripcion;
        $afp->save();

        flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('afps.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $afp=Afp::findOrFail($id);
        $afp->delete();
        flash('La AFP '.$afp->descripcion.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('afps.index');
    }
}
