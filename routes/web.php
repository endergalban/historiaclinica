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
});


/*Especialidades*/
Route::group(['middleware' => 'roles','site'=>'especialidades'], function () {

	Route::resource('especialidades','EspecialidadesController',['except' => ['delete','show']]);
	Route::get('especialidades/{id}/destroy',['uses'=>'EspecialidadesController@destroy','as'=>'especialidades.destroy']);

});

/*Historias*/
Route::group(['middleware' => 'roles','site'=>'pacientes'], function () {
	Route::resource('historias','HistoriasController',['except' => ['delete']]);
	Route::get('historias/{id}/destroy',['uses'=>'HistoriasController@destroy','as'=>'historias.destroy']);
	Route::get('historias/{id}/{tipo}/{medico_id?}',['uses'=>'HistoriasController@historia','as'=>'historias.historia']);
	Route::get('historias/{id}/ocupacional/{medico_paciente}/create',['uses'=>'HistoriasController@ocupacional_create','as'=>'historias.ocupacional.create']);
	Route::get('historias/{id}/ocupacional/{medico_paciente}/edit',['uses'=>'HistoriasController@ocupacional_edit','as'=>'historias.ocupacional.edit']);

	Route::get('historias/{id}/ocupacional/{medico_paciente}/antecedentes',['uses'=>'HistoriasController@ocupacional_antecedentes','as'=>'historias.ocupacional.antecedentes']);
	Route::post('historias/{id}/ocupacional/{medico_paciente}/antecedentes/store',['uses'=>'HistoriasController@ocupacional_antecedentes_store','as'=>'historias.ocupacional.antecedentes.store']);
	Route::get('historias/{id}/ocupacional/{medico_paciente}/antecedentes/{antecedente_ocupacional_id}/destroy',['uses'=>'HistoriasController@ocupacional_antecedentes_destroy','as'=>'historias.ocupacional.antecedentes.destroy']);


	Route::get('historias/{id}/ocupacional/{medico_paciente}/patologias',['uses'=>'HistoriasController@ocupacional_patologias','as'=>'historias.ocupacional.patologias']);
	Route::get('historias/{id}/ocupacional/{medico_paciente}/actual',['uses'=>'HistoriasController@ocupacional_actual','as'=>'historias.ocupacional.actual']);
	Route::get('historias/{id}/ocupacional/{medico_paciente}/fisicos',['uses'=>'HistoriasController@ocupacional_fisicos','as'=>'historias.ocupacional.fisicos']);
	Route::get('historias/{id}/ocupacional/{medico_paciente}/examenes',['uses'=>'HistoriasController@ocupacional_examenes','as'=>'historias.ocupacional.examenes']);
	Route::get('historias/{id}/ocupacional/{medico_paciente}/diagnosticos',['uses'=>'HistoriasController@ocupacional_diagnosticos','as'=>'historias.ocupacional.diagnosticos']);
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


Route::get('perfil','PerfilController@index')->name('perfil.index');
Route::put('perfil/{id}','PerfilController@update')->name('perfil.update');


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

