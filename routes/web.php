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

