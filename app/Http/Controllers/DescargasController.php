<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;
use Storage;
use Response;

class DescargasController extends Controller
{
	 /**
     * .
     * Descarga un documento
     * @param  $request->search  para filtro de resultado
     */
    public function descargar($file){

 
    	$file=Crypt::decrypt($file);
		$nombre= pathinfo(storage_path('app/public/').$file, PATHINFO_BASENAME);
		$mime=Storage::disk('public')->getMimetype($file);
		$headers = array(
      	 	'Content-Type: '.$mime.'',
  		);
  		$file_path=storage_path('app/public/').$file;
  		$response = response()->download($file_path,$nombre,$headers);
  		ob_end_clean();
		return $response;
    }
}
