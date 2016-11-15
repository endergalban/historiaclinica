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
     * .
     * Muestra los arl del sistema
     * @param  $request->search  para filtro de resultado
     */
     public function index(Request $request)
    {
        $arls=Arl::ofType($request->search)->orderby('descripcion','ASC')->paginate(15);
        return  view('arls.index')->with(['arls'=>$arls]);
    }

    /**
     * .
     * Configura el formulario para la creación del arl
     * 
     */
    public function create()
    {
         return  view('arls.create');
    }

    /**
     * .
     * Registra un arl en el sistema
     *  @param  $request con los datos del arl
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
     * .
     * Muestra los datos de un arl en el sistema para su edición
     *  @param  $id del arl
     */
    public function edit($id)
    {
       $arl=Arl::findOrFail($id);
       return  view('arls.edit')->with('arl',$arl);
    }

     /**
     * .
     * Edita los datos de un arl 
     *  @param  $request con los datos de un arl 
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
     * .
     * Elimina un arl 
     *  @param  $id del arl 
     */
    public function destroy($id)
    {
        $arl=Arl::findOrFail($id);
        $arl->delete();
        flash('La ARL '.$arl->descripcion.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('arls.index');
    }
}
