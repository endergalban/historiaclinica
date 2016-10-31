<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use Image;
use App\User;
use App\Medico;
use App\Asistente;
use App\Role;
use App\Pais;
use App\Departamento;
use App\Municipio;
use Carbon\Carbon;
use App\Paciente;
use App\Empresa;
use App\Arl;
use App\Afp;
use Auth;

class HistoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $users=User::ofType($request->search)->has('paciente')->orderby('numerodocumento','ASC')->paginate(15);
         
        $medico=Medico::has('user')->where('user_id',Auth::user()->id)->first();
        $asistente=Asistente::has('user')->where('user_id',Auth::user()->id)->first();
        if($medico){

            $medicos=$medico->id;

        }elseif($asistente){
            

            $querymedicos=User::findOrFail(Auth::user()->id);
            $querymedicos->asistente();
            dd($querymedicos->asistente);
            foreach ($querymedicos as $asistente) {
                $medicos[$asistente->medico->user->id]=$asistente->user->tipodocumento;
            }

        }else{
          
            $querymedicos=User::has('medico')->orderby('tipodocumento','ASC')->get();
            foreach ($querymedicos as $medico) {
                $medicos[$medico->medico->id]=$medico->tipodocumento.' '.$medico->numerodocumento.' '.$medico->primerapellido.' '.$medico->primernombre;
            }
        }
         
        return  view('historias.index')->with(['users'=>$users,'medicos'=>$medicos ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $user=User::with('municipio.departamento.pais')->with('paciente')->where('id',$id)->first();
       

      
      
      /*  $empresas=Empresa::all()->sortBy('descripcion')->pluck('descripcion', 'id')->prepend('N/A', 0);
        $arls=Arl::all()->sortBy('descripcion')->pluck('descripcion', 'id')->prepend('N/A', 0);
        $afps=Afp::all()->sortBy('descripcion')->pluck('descripcion', 'id')->prepend('N/A', 0);

        $user=User::with('municipio.departamento.pais')->with('paciente')->where('id',$id)->first();
*/

        return  view('historias.edit')->with(['user' => $user]);
    }

    public function historia($id,$tipo)
    {
        echo $tipo;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
