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
     * .
     * Muestra los afp del sistema
     * @param  $request->search  para filtro de resultado
     */
     public function index(Request $request)
    {
        $afps=Afp::ofType($request->search)->orderby('descripcion','ASC')->paginate(15);
        return  view('afps.index')->with(['afps'=>$afps]);
    }

    /**
     * .
     * Configura el formulario para la creación del afp
     * 
     */
    public function create()
    {
         return  view('afps.create');
    }

     /**
     * .
     * Registra un afp en el sistema
     *  @param  $request con los datos del afp
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
     * .
     * Muestra los datos de un afp en el sistema para su edición
     *  @param  $id del afp
     */
    public function edit($id)
    {
       $afp=Afp::findOrFail($id);
       return  view('afps.edit')->with('afp',$afp);
    }

     /**
     * .
     * Edita los datos de un afp 
     *  @param  $request con los datos de un afp 
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
     * .
     * Elimina un afp 
     *  @param  $id del afp 
     */
    public function destroy($id)
    {
        $afp=Afp::findOrFail($id);
        $afp->delete();
        flash('La AFP '.$afp->descripcion.' se ha eliminado de forma exitosa!', 'danger');
        return redirect()->route('afps.index');
    }
}
