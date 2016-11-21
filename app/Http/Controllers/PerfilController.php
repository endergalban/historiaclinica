<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use Auth;
use App\User;
use Image;
use Carbon\Carbon;


class PerfilController extends Controller
{
     /**
     * .
     * Muestra el perfil
     *
     */
    public function index()
    {
        return	view('perfil');
    }

     /**
     * .
     * Edita el perfil
     *  @param  $request con los datos del perfil
     */
    public function update(Request $request, $id)
    {
		 $user	=	User::find($id);
         $validator = Validator::make($request->all(), [
            'password' => 'string||min:6|max:16|confirmed',   
            'imagen' => 'image',   
            'firma' => 'image',              
        ]);
        if ($validator->fails()) {
            flash(implode('<br>',$validator->errors()->all()), 'danger');
            return redirect()->route('perfil.index');
        }
        if(!empty($request->password))
        {
            $user->password= bcrypt($request->password);
            $user->save();    
        }    
        if( $request->hasFile('imagen')){ 
            $imageName = $user->id . '.' . $request->file('imagen')->getClientOriginalExtension();
            Image::make($request->file('imagen'))->resize(null, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/users/'.$imageName);
            $user->imagen=$imageName;
            $user->save();
        }
        if( $request->hasFile('firma')){ 
            $imagefirma = $user->id . '.' . $request->file('firma')->getClientOriginalExtension();
            Image::make($request->file('firma'))->resize(null, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/firmas/'.$imagefirma);
            $user->firma=$imagefirma;
            $user->save();
        }

		flash('Edición realizada de forma exitosa!', 'success');
        return redirect()->route('perfil.index');
    }
}
