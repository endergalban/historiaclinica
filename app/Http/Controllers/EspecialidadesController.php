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
     * .
     * Muestra las especialidades del sistema
     * @param  $request->search  para filtro de resultado
     */
    public function index(Request $request)
    {
        $especialidades=Especialidad::ofType($request->search)->orderby('descripcion','ASC')->paginate(15);
        return  view('especialidades.index')->with(['especialidades'=>$especialidades]);
    }

    /**
     * .
     * Configura el formulario para la creación de la especialidad
     * 
     */
    public function create()
    {
         return  view('especialidades.create');
    }

     /**
     * .
     * Registra los datos de una especialidad en el sistema
     *  @param $request con los datos de una especialidad 
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
     * .
     * Muestra los datos de una especialidad en el sistema para su edición
     *  @param  $id de la especialidad
     */
    public function edit($id)
    {
       $especialidad=Especialidad::findOrFail($id);
       return  view('especialidades.edit')->with('especialidad',$especialidad);
    }

     /**
     * .
     * Edita los datos de una especialidad 
     *  @param  $request con los datos de una especialidad 
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
     * .
     * Elimina una especialidad 
     *  @param  $id de la especialidad 
     */
    public function destroy($id)
    {
        $especialidad=Especialidad::findOrFail($id);
        $especialidad->delete();
        flash('La especialidad '.$especialidad->descripcion.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('especialidades.index');
    }
}
