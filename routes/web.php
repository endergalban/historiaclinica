	<?php

	/*
	|--------------------------------------------------------------------------
	| Web Routes
	|--------------------------------------------------------------------------
	|
	| This file is where you may define all of the routes that are handled
	| by your application. Just tell Laravel the URIs it should respond
	| to using a Closure or controller method. Build something great!
	|
	*/

Route::group(['middleware' => 'roles','site'=>'home'], function () {
	Route::get('/',	function(){	return	view('home');})->name('home');
});	

/*Afps*/
Route::group(['middleware' => 'roles','site'=>'afps'], function () {

	Route::resource('afps','AfpsController',['except' => ['delete','show']]);
	Route::get('afps/{id}/destroy',['uses'=>'AfpsController@destroy','as'=>'afps.destroy']);

});

/*Arls*/
Route::group(['middleware' => 'roles','site'=>'arls'], function () {

	Route::resource('arls','ArlsController',['except' => ['delete','show']]);
	Route::get('arls/{id}/destroy',['uses'=>'ArlsController@destroy','as'=>'arls.destroy']);

});

/*Asistentes*/
Route::group(['middleware' => 'roles','site'=>'asistentes'], function () {

	Route::resource('asistentes','AsistentesController',['except' => 'delete']);
	Route::get('asistentes/{id}/destroy',['uses'	=>'AsistentesController@destroy','as'=>'asistentes.destroy']);
	Route::get('asistentes/{id}/password',['uses'=>'AsistentesController@password','as'=>'asistentes.password']);

});

/*Citas*/
Route::group(['middleware' => 'roles','site'=>'citas'], function () {


		Route::resource('citas','CitasController',['except' => ['delete','show']]);
		Route::get('citas/{id}/destroy',['uses'=>'CitasController@destroy','as'=>'citas.destroy']);
  		Route::post('guardarcita', array('as'=> 'guardarcita', 'uses'=> 'CitasController@create'));
  		Route::post('eliminarcita', array('as'=> 'eliminarcita', 'uses'=> 'CitasController@borrar'));
  		Route::get('api','CitasController@api');
});

/*Combos*/
Route::group(['middleware' => 'roles','site'=>'all'], function () {

	Route::get('/getDataDepartamantos/{id}',	function($id){	
        $dataDepartamantos= App\Departamento::all()->where('pais_id',$id);
		return Response::json($dataDepartamantos);
	})->name('getDataDepartamantos');

	Route::get('/getDataMunicipios/{id}',function($id){	
        $dataMunicipios= App\Municipio::all()->where('departamento_id',$id);
		return Response::json($dataMunicipios);
	})->name('dataMunicipios');

	Route::get('/getDataEspecialidades/{id}',	function($id){	
        $dataEspecialidades= App\Medico::with('especialidades')->where('id',$id)->get();
		return Response::json($dataEspecialidades);
	})->name('getDataEspecialidades');

	Route::get('/getTipoDiagnostico/{descripcion?}',function($descripcion = ''){	
        $dataTipoDiagnosticos= App\Tipo_diagnostico::ofType($descripcion)->limit(15)->pluck('descripcion','id');
        $valid_tags=array();
        foreach ($dataTipoDiagnosticos as $id => $dataTipoDiagnostico) {
            $valid_tags[] = ['id' => $id, 'text' => $dataTipoDiagnostico];
        }
   		return Response::json($valid_tags);
	})->name('dataTipoDiagnostico');

});

/*Descargas*/
Route::group(['middleware' => 'roles','site'=>'all'], function () {
	Route::get('descargar/{file}',['uses'=>'DescargasController@descargar','as'=>'descargar']);
});

/*Especialidades*/
Route::group(['middleware' => 'roles','site'=>'especialidades'], function () {

	Route::resource('especialidades','EspecialidadesController',['except' => ['delete','show']]);
	Route::get('especialidades/{id}/destroy',['uses'=>'EspecialidadesController@destroy','as'=>'especialidades.destroy']);

});

/*Historias*/
Route::group(['middleware' => 'roles','site'=>'historias'], function () {

	Route::resource('historias','HistoriasController',['only' => ['index']]);
	Route::get('historias/{id}/{tipo}/{medico_id?}',['uses'=>'HistoriasController@historia','as'=>'historias.historia']);


/////////////////	//GINECOLOGICA//   ///////////////////////////////////////////////
	Route::get('historias/{id}/ginecologica/{medico_paciente}/index',['uses'=>'HistoriasGinecologicaController@index','as'=>'historias.ginecologica.index']);
	
	Route::get('historias/{id}/ginecologica/{medico_paciente}/create',['uses'=>'HistoriasGinecologicaController@ginecologica_create','as'=>'historias.ginecologica.create']);

	Route::get('historias/{id}/ginecologica/{medico_id}/{historia_ginecologica_id}/destroy',['uses'=>'HistoriasGinecologicaController@destroy_ginecologica','as'=>'historias.destroy_ginecologica']);


	//DOCUMENTOS
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/documentos',['uses'=>'HistoriasGinecologicaController@ginecologica_documentos','as'=>'historias.ginecologica.documentos']);
	Route::post('historias/{id}/ginecologica/{historia_ginecologica_id}/documentos/store',['uses'=>'HistoriasGinecologicaController@ginecologica_documentos_store','as'=>'historias.ginecologica.documentos.store']);
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/documentos/{documento}/destroy',['uses'=>'HistoriasGinecologicaController@ginecologica_documentos_destroy','as'=>'historias.ginecologica.documentos.destroy']);

	//ANTECEDENTES
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/antecedentes',['uses'=>'HistoriasGinecologicaController@ginecologica_antecedentes','as'=>'historias.ginecologica.antecedentes']);
	Route::post('historias/{id}/ginecologica/{historia_ginecologica_id}/antecedentes/store',['uses'=>'HistoriasGinecologicaController@ginecologica_antecedentes_store','as'=>'historias.ginecologica.antecedentes.store']);

	//ANTECEDENTES GINECOBSTETRICA
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/ginecobstetrica',['uses'=>'HistoriasGinecologicaController@ginecologica_ginecobstetrica','as'=>'historias.ginecologica.ginecobstetrica']);
	Route::post('historias/{id}/ginecologica/{historia_ginecologica_id}/ginecobstetrica/store',['uses'=>'HistoriasGinecologicaController@ginecologica_ginecobstetrica_store','as'=>'historias.ginecologica.ginecobstetrica.store']);

	//DATOS DE LA CONSULTA
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/edit',['uses'=>'HistoriasGinecologicaController@ginecologica_edit','as'=>'historias.ginecologica.edit']);
	Route::post('historias/{id}/ginecologica/{historia_ginecologica_id}/edit/store',['uses'=>'HistoriasGinecologicaController@ginecologica_edit_store','as'=>'historias.ginecologica.edit.store']);

	//EXPLORACION FISICA
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/fisicos',['uses'=>'HistoriasGinecologicaController@ginecologica_fisicos','as'=>'historias.ginecologica.fisicos']);
	Route::post('historias/{id}/ginecologica/{historia_ginecologica_id}/fisicos/store',['uses'=>'HistoriasGinecologicaController@ginecologica_fisicos_store','as'=>'historias.ginecologica.fisicos.store']);
	

	//DIAGNOSTICOS
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/diagnosticos',['uses'=>'HistoriasGinecologicaController@ginecologica_diagnosticos','as'=>'historias.ginecologica.diagnosticos']);
	Route::post('historias/{id}/ginecologica/{historia_ginecologica_id}/diagnosticos/store',['uses'=>'HistoriasGinecologicaController@ginecologica_diagnosticos_store','as'=>'historias.ginecologica.diagnosticos.store']);
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/diagnosticos/{ginecologia_diagnostico_id}/destroy',['uses'=>'HistoriasGinecologicaController@ginecologica_diagnosticos_destroy','as'=>'historias.ginecologica.diagnosticos.destroy']);

	//ANALISIS Y PROCEDIMIENTOS
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/procedimientos',['uses'=>'HistoriasGinecologicaController@ginecologica_procedimientos','as'=>'historias.ginecologica.procedimientos']);
	Route::post('historias/{id}/ginecologica/{historia_ginecologica_id}/procedimientos/store',['uses'=>'HistoriasGinecologicaController@ginecologica_procedimientos_store','as'=>'historias.ginecologica.procedimientos.store']);

	//RECOMEDACIONES
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/recomendaciones',['uses'=>'HistoriasGinecologicaController@ginecologica_recomendaciones','as'=>'historias.ginecologica.recomendaciones']);
	Route::post('historias/{id}/ginecologica/{historia_ginecologica_id}/recomendaciones/store',['uses'=>'HistoriasGinecologicaController@ginecologica_recomendaciones_store','as'=>'historias.ginecologica.recomendaciones.store']);

	//INCAPACIDAD
	Route::get('historias/{id}/ginecologica/{historia_ginecologica_id}/incapacidad',['uses'=>'HistoriasGinecologicaController@ginecologica_incapacidad','as'=>'historias.ginecologica.incapacidad']);
	Route::post('historias/{id}/ginecologica/{historia_ginecologica_id}/incapacidad/store',['uses'=>'HistoriasGinecologicaController@ginecologica_incapacidad_store','as'=>'historias.ginecologica.incapacidad.store']);


/////////////////	//OCUPACIONAL//   ///////////////////////////////////////////////
	Route::get('historias/{id}/ocupacional/{medico_paciente}/index',['uses'=>'HistoriasOcupacionalController@index','as'=>'historias.ocupacional.index']);
	
	Route::get('historias/{id}/ocupacional/{medico_paciente}/create',['uses'=>'HistoriasOcupacionalController@ocupacional_create','as'=>'historias.ocupacional.create']);

	Route::get('historias/{id}/ocupacional/{medico_id}/{historia_ocupacional_id}/destroy',['uses'=>'HistoriasOcupacionalController@destroy_ocupacional','as'=>'historias.destroy_ocupacional']);


	//DOCUMENTOS
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/documentos',['uses'=>'HistoriasOcupacionalController@ocupacional_documentos','as'=>'historias.ocupacional.documentos']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/documentos/store',['uses'=>'HistoriasOcupacionalController@ocupacional_documentos_store','as'=>'historias.ocupacional.documentos.store']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/documentos/{documento}/destroy',['uses'=>'HistoriasOcupacionalController@ocupacional_documentos_destroy','as'=>'historias.ocupacional.documentos.destroy']);

	//DATOS DEL PACIENTE
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/edit',['uses'=>'HistoriasOcupacionalController@ocupacional_edit','as'=>'historias.ocupacional.edit']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/edit/store',['uses'=>'HistoriasOcupacionalController@ocupacional_edit_store','as'=>'historias.ocupacional.edit.store']);

	//CONSENTIMIENTOS
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/consentimientos',['uses'=>'HistoriasOcupacionalController@ocupacional_consentimientos','as'=>'historias.ocupacional.consentimientos']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/consentimientos/store',['uses'=>'HistoriasOcupacionalController@ocupacional_consentimientos_store','as'=>'historias.ocupacional.consentimientos.store']);
	
	//ANTECEDENTES
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/antecedentes',['uses'=>'HistoriasOcupacionalController@ocupacional_antecedentes','as'=>'historias.ocupacional.antecedentes']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/antecedentes/store',['uses'=>'HistoriasOcupacionalController@ocupacional_antecedentes_store','as'=>'historias.ocupacional.antecedentes.store']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/antecedentes/{antecedente_ocupacional_id}/destroy',['uses'=>'HistoriasOcupacionalController@ocupacional_antecedentes_destroy','as'=>'historias.ocupacional.antecedentes.destroy']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/antecedentes/riesgos/{antecedente_ocupacional_id}/',['uses'=>'HistoriasOcupacionalController@ocupacional_antecedentes_riesgos','as'=>'historias.ocupacional.antecedentes.riesgos']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/antecedentes/riesgos/{antecedente_ocupacional_id}/store',['uses'=>'HistoriasOcupacionalController@ocupacional_antecedentes_riesgos_store','as'=>'historias.ocupacional.antecedentes.riesgos.store']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/antecedentes/{antecedente_ocupacional_id}/{ant_ocu_fac_rie_id}/destroy_riesgo',['uses'=>'HistoriasOcupacionalController@ocupacional_antecedentes_destroy_riesgo','as'=>'historias.ocupacional.antecedentes.destroy_riesgo']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/antecedentes/lesiones/{antecedente_ocupacional_id}/',['uses'=>'HistoriasOcupacionalController@ocupacional_antecedentes_lesiones','as'=>'historias.ocupacional.antecedentes.lesiones']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/antecedentes/lesiones/{antecedente_ocupacional_id}/store',['uses'=>'HistoriasOcupacionalController@ocupacional_antecedentes_lesiones_store','as'=>'historias.ocupacional.antecedentes.lesiones.store']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/antecedentes/{antecedente_ocupacional_id}/{tramatologico_id}/destroy_lesion',['uses'=>'HistoriasOcupacionalController@ocupacional_antecedentes_destroy_lesion','as'=>'historias.ocupacional.antecedentes.destroy_lesion']);

	//PATOLOGIAS
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/patologias',['uses'=>'HistoriasOcupacionalController@ocupacional_patologias','as'=>'historias.ocupacional.patologias']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/patologias/store_vacuna',['uses'=>'HistoriasOcupacionalController@ocupacional_patologias_store_vacuna','as'=>'historias.ocupacional.patologias.store_vacuna']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/patologias/store_enfermedad',['uses'=>'HistoriasOcupacionalController@ocupacional_patologias_store_enfermedad','as'=>'historias.ocupacional.patologias.store_enfermedad']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/patologias/store_ginecobstetrica',['uses'=>'HistoriasOcupacionalController@ocupacional_patologias_store_ginecobstetrica','as'=>'historias.ocupacional.patologias.store_ginecobstetrica']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/patologias/store_habitos',['uses'=>'HistoriasOcupacionalController@ocupacional_patologias_store_habitos','as'=>'historias.ocupacional.patologias.store_habitos']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/patologias/{inmunizaciones_id}/destroy_enfermedad',['uses'=>'HistoriasOcupacionalController@ocupacional_patologias_destroy_enfermedad','as'=>'historias.ocupacional.patologias.destroy_enfermedad']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/patologias/{patologico_id}/destroy_vacuna',['uses'=>'HistoriasOcupacionalController@ocupacional_patologias_destroy_vacuna','as'=>'historias.ocupacional.patologias.destroy_vacuna']);

	//OCUPACION ACTUAL
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/actual',['uses'=>'HistoriasOcupacionalController@ocupacional_actual','as'=>'historias.ocupacional.actual']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/actual/store',['uses'=>'HistoriasOcupacionalController@ocupacional_actual_store','as'=>'historias.ocupacional.actual.store']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/actual/store_factor',['uses'=>'HistoriasOcupacionalController@ocupacional_actual_store_factor','as'=>'historias.ocupacional.actual.store_factor']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/actual/{antecedente_ocupacional_id}/destroy_factor',['uses'=>'HistoriasOcupacionalController@ocupacional_actual_destroy_factor','as'=>'historias.ocupacional.actual.destroy_factor']);


	//EXAMENES DE FISICOS
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/fisicos',['uses'=>'HistoriasOcupacionalController@ocupacional_fisicos','as'=>'historias.ocupacional.fisicos']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/fisicos/store',['uses'=>'HistoriasOcupacionalController@ocupacional_fisicos_store','as'=>'historias.ocupacional.fisicos.store']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/fisicos/store_exploracion',['uses'=>'HistoriasOcupacionalController@ocupacional_fisicos_store_exploracion','as'=>'historias.ocupacional.fisicos.store_exploracion']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/fisicos/{explracion_id}/destroy_exploracion',['uses'=>'HistoriasOcupacionalController@ocupacional_fisicos_destroy_exploracion','as'=>'historias.ocupacional.fisicos.destroy_exploracion']);

	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/fisicos/store_visual',['uses'=>'HistoriasOcupacionalController@ocupacional_fisicos_store_visual','as'=>'historias.ocupacional.fisicos.store_visual']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/fisicos/{visual_id}/destroy_visual',['uses'=>'HistoriasOcupacionalController@ocupacional_fisicos_destroy_visual','as'=>'historias.ocupacional.fisicos.destroy_visual']);
	

	//EXAMENES DE LABORATORIO
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/examenes',['uses'=>'HistoriasOcupacionalController@ocupacional_examenes','as'=>'historias.ocupacional.examenes']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/examenes/store',['uses'=>'HistoriasOcupacionalController@ocupacional_examenes_store','as'=>'historias.ocupacional.examenes.store']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/examenes/{antecedente_ocupacional_id}/destroy',['uses'=>'HistoriasOcupacionalController@ocupacional_examenes_destroy','as'=>'historias.ocupacional.examenes.destroy']);

	//ALTURAS
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/alturas',['uses'=>'HistoriasOcupacionalController@ocupacional_alturas','as'=>'historias.ocupacional.alturas']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/alturas/store_condicion',['uses'=>'HistoriasOcupacionalController@ocupacional_alturas_store_condicion','as'=>'historias.ocupacional.alturas.store_condicion']);

	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/alturas/store',['uses'=>'HistoriasOcupacionalController@ocupacional_alturas_store','as'=>'historias.ocupacional.alturas.store']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/alturas/{examen_altura_id}/destroy',['uses'=>'HistoriasOcupacionalController@ocupacional_alturas_destroy','as'=>'historias.ocupacional.alturas.destroy']);


	//DIAGNOSTICOS
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/diagnosticos',['uses'=>'HistoriasOcupacionalController@ocupacional_diagnosticos','as'=>'historias.ocupacional.diagnosticos']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/diagnosticos/store_condicion',['uses'=>'HistoriasOcupacionalController@ocupacional_diagnosticos_store_condicion','as'=>'historias.ocupacional.diagnosticos.store_condicion']);

	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/diagnosticos/store',['uses'=>'HistoriasOcupacionalController@ocupacional_diagnosticos_store','as'=>'historias.ocupacional.diagnosticos.store']);
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/diagnosticos/{antecedente_ocupacional_id}/destroy',['uses'=>'HistoriasOcupacionalController@ocupacional_diagnosticos_destroy','as'=>'historias.ocupacional.diagnosticos.destroy']);

	//RECOMEDACIONES
	Route::get('historias/{id}/ocupacional/{historia_ocupacional_id}/recomendaciones',['uses'=>'HistoriasOcupacionalController@ocupacional_recomendaciones','as'=>'historias.ocupacional.recomendaciones']);
	Route::post('historias/{id}/ocupacional/{historia_ocupacional_id}/recomendaciones/store',['uses'=>'HistoriasOcupacionalController@ocupacional_recomendaciones_store','as'=>'historias.ocupacional.recomendaciones.store']);
	
});

/*Médicos*/
Route::group(['middleware' => 'roles','site'=>'medicos'], function () {

	Route::resource('medicos','MedicosController',['except' => 'delete']);
	Route::get('medicos/{id}/destroy',['uses'	=>'MedicosController@destroy','as'=>'medicos.destroy']);
	Route::get('medicos/{id}/password',['uses'=>'MedicosController@password','as'=>'medicos.password']);

});

/*Módulos*/
Route::group(['middleware' => 'roles','site'=>'modulos'], function () {

	Route::resource('modulos','ModulosController',['except' => ['delete']]);
	Route::get('modulos/{id}/destroy',['uses'=>'ModulosController@destroy','as'=>'modulos.destroy']);

});

/*Empresas*/
Route::group(['middleware' => 'roles','site'=>'empresas'], function () {

	Route::resource('empresas','EmpresasController',['except' => ['delete']]);
	Route::get('empresas/{id}/destroy',['uses'=>'EmpresasController@destroy','as'=>'empresas.destroy']);
});

/*Pacientes*/
Route::group(['middleware' => 'roles','site'=>'pacientes'], function () {

	Route::resource('pacientes','PacientesController',['except' => 'delete']);
	Route::get('pacientes/{id}/destroy',['uses'	=>'PacientesController@destroy','as'=>'pacientes.destroy']);
	Route::get('pacientes/{id}/password',['uses'=>'PacientesController@password','as'=>'pacientes.password']);

});

/*Perfil*/
Route::group(['middleware' => 'roles','site'=>'all'], function () {
	Route::get('perfil','PerfilController@index')->name('perfil.index');
	Route::put('perfil/{id}','PerfilController@update')->name('perfil.update');
});

/*Reportes*/
Route::group(['middleware' => 'roles','site'=>'all'], function () {
	Route::get('reportes/{historia_ocupacional_id}/trabajo_altura',['uses'=>'ReportsController@trabajo_altura','as'=>'reporte.trabajo_altura']);
	Route::get('reportes/{historia_ocupacional_id}/certificado_ocupacional',['uses'=>'ReportsController@certificado_ocupacional','as'=>'reporte.certificado_ocupacional']);
	Route::get('reportes/{historia_ocupacional_id}/historia',['uses'=>'ReportsController@historia','as'=>'reporte.historia']);
	Route::get('reportes/{historia_ocupacional_id}/consentimiento_informado',['uses'=>'ReportsController@consentimiento_informado','as'=>'reporte.consentimiento_informado']);
	Route::get('reportes/{historia_ocupacional_id}/aptitud_laboral',['uses'=>'ReportsController@aptitud_laboral','as'=>'reporte.aptitud_laboral']);
});

/*Usuarios*/
Route::group(['middleware' => 'roles','site'=>'users'], function () {

	Route::resource('users','UsersController',['except' => 'delete']);
	Route::get('users/{id}/destroy',['uses'	=>'UsersController@destroy','as'=>'users.destroy']);
	Route::get('users/{id}/password',['uses'=>'UsersController@password','as'=>'users.password']);
	Route::get('users/{id}/estatus',['uses'	=>'UsersController@estatus','as'=>'users.estatus']);
	Route::get('users/{id}/role/{role_id}',['uses'	=>'UsersController@role','as'=>'users.role']);
	Route::put('user/{id}/medico', ['uses'	=>'UsersController@medico','as'=>'users.updaterolemedico']);
	Route::put('user/{id}/paciente', ['uses'=>'UsersController@paciente','as'=>'users.updaterolepaciente']);
	Route::put('user/{id}/asistente', ['uses'=>'UsersController@asistente','as'=>'users.updateroleasistente']);
});

Auth::routes();

