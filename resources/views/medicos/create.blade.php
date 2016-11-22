@extends('layouts.main')

@section('content-header')
     <h1>
        Médicos
        <small>Crear nuevo médico</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('medicos.index') }}">Médicos</a></li>
        <li class="active">Crear nuevo médico</li>
      </ol>
@endsection

@section('content')

  <div class="box box-default">
        <div class="box-header with-border">
			<div class="box-header">
				  <a href="{{ route('medicos.index') }}"><button type="submit" class="btn btn-default btn-sm">Ver lista de médicos</button></a>
			</div>
          	<div class="box-tools pull-right">
          		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          	</div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        @include('flash::message')
          <div class="row">
          	{!! Form::open(['class' => '','method' => 'POST','route' => 'medicos.store','role' => 'form','files' => true]) !!}

          		<div class="col-md-12">
				    <div class="form-group col-md-1">
					 	<img class='profile-user-img img-responsive' src="{{ asset('images/users/avatar.png')}}" />
				    </div>
    			</div>

      			<div class="col-md-12">
               		<div class="form-group col-md-3">
					 	{!! Form::label('imagen','Imagen de usuario') !!}
					    {!! Form::file('imagen', old('imagen'),['class'=>'form-control']) !!}
				    </div>
				</div>
				
	          	<div class="col-md-12">
	            	<div class="form-group col-md-3">
	            	  {!! Form::label('tipodocumento','T. Documento') !!}
	                  {!! Form::select('tipodocumento', 
	                  [
		                   'CC' => 'Cédula de Ciudadanía',
		                   'CE' => 'Cédula de Extranjería',
		                   'RC' => 'Registro civil', 
		                   'TI>' => 'Tarjeta de Identidad'

	                   ], old('tipodocumento'),['class' => 'form-control select2','style' => 'width: 100%']) !!}
	                </div>

	                <div class="form-group col-md-3">
	            	  {!! Form::label('numerodocumento','Nro. Documento') !!}
	                  {!! Form::text('numerodocumento',old('numerodocumento'),['placeholder' => '','class'=>'form-control']) !!}
	                </div>

	                <div class="form-group col-md-4">
	            	  {!! Form::label('email','Email') !!}
	                  {!! Form::Email('email',old('email'),['placeholder' => 'example@gmail.com','class'=>'form-control']) !!}
	                </div>

	                <div class="form-group col-md-2">
	            	  {!! Form::label('activo','Estatus') !!}
	                  {!! Form::select('activo', 
	                  [
		                   true  => 'Activo',
		                   false => 'Inactivo'

	                   ], old('activo'),['class' => 'form-control select2','style' => 'width: 100%']) !!}
	                </div>
	              <!-- /.form-group -->
	            </div>

	             <div class="col-md-12">
	            	<div class="form-group col-md-3">
	            	  {!! Form::label('primernombre','Primer Nombre') !!}
	                  {!! Form::text('primernombre',old('primernombre'),['placeholder' => '','class'=>'form-control']) !!}
	                </div>

	                <div class="form-group col-md-3">
	            	  {!! Form::label('segundonombre','Segundo Nombre') !!}
	                  {!! Form::text('segundonombre',old('segundonombre'),['placeholder' => '','class'=>'form-control']) !!}
	                </div>
	            
	            	<div class="form-group col-md-3">
	            	  {!! Form::label('primerapellido','Primer Apellido') !!}
	                  {!! Form::text('primerapellido',old('primerapellido'),['placeholder' => '','class'=>'form-control']) !!}
	                </div>

	                <div class="form-group col-md-3">
	            	  {!! Form::label('segundoapellido','Segundo Apellido') !!}
	                  {!! Form::text('segundoapellido',old('segundoapellido'),['placeholder' => '','class'=>'form-control']) !!}
	                </div>
	              <!-- /.form-group -->
	            </div>

	            <div class="col-md-12">
	            	<div class="form-group col-md-3">
	            	  {!! Form::label('genero','Genero') !!}
	                  {!! Form::select('genero', 
	                  [
		                   'Masculino'  => 'Masculino',
		                   'Femenino' => 'Femenino',
		                   'Otro' => 'Otro',

	                   ], old('genero'),['class' => 'form-control select2','style' => 'width: 100%']) !!}
	                </div>

	                <div class="form-group col-md-2">
	            	  {!! Form::label('fechanacimiento','Fecha Nac.') !!}
	                  {!! Form::text('fechanacimiento',old('fechanacimiento'),['placeholder' => '28/12/1981','class'=>'form-control datepicker']) !!}
	                </div>
	            
	            	<div class="form-group col-md-3">
	            	  {!! Form::label('estadocivil','Estado Civil') !!}
	                  {!! Form::select('estadocivil', 
	                  [
		                   'Soltero/a'  => 'Soltero/a',
		                   'Casado/a' => 'Casado/a',
		                   'Divorciado/a' => 'Divorciado/a',
		                   'Viudo/a' => 'Viudo/a',
		                   'Union Libre' => 'Union Libre',

	                   ], old('estadocivil'),['class' => 'form-control select2','style' => 'width: 100%']) !!}
	                </div>

	                <div class="form-group col-md-4	">
	            	  {!! Form::label('ocupacion','Ocupación') !!}
	                  {!! Form::text('ocupacion',old('tipodocumento'),['placeholder' => '','class'=>'form-control']) !!}
	                </div>
	              <!-- /.form-group -->
	            </div>

	             <div class="col-md-12">
	            	<div class="form-group col-md-4">
	            	  {!! Form::label('pais_id','País Nac.') !!}
	                  {!! Form::select('pais_id',$nacimiento['paises'], old('pais_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
	                </div>

	                <div class="form-group col-md-4">
	            	  {!! Form::label('departamento_id','Departamento Nac.') !!}
	                  {!! Form::select('departamento_id',$nacimiento['departamentos'], old('departamento_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
	                </div>
	            
	            	<div class="form-group col-md-4">
	            	  {!! Form::label('municipio_id','Municipio Nac.') !!}
	                  {!! Form::select('municipio_id',$nacimiento['municipios'], old('municipio_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
	                </div>
	              <!-- /.form-group -->
	            </div>
	            

	            <div class="col-md-12">
	            	<div class="form-group col-md-3">
	            	  {!! Form::label('telefono','Teléfono') !!}
	                  {!! Form::text('telefono',old('telefono'),['placeholder' => '058414664956','class'=>'form-control']) !!}
	                </div>

	                <div class="form-group col-md-9">
	            	  {!! Form::label('direccion','Dirección') !!}
	                  {!! Form::text('direccion',old('direccion'),['placeholder' => '','class'=>'form-control']) !!}
	                </div>
	              <!-- /.form-group -->
	            </div>

	             <div class="col-md-12">
	            	
  	                <div class="form-group col-md-3">
  	            	  {!! Form::label('registro','Nro. Registro') !!}
  	                  {!! Form::text('registro',old('registro'),['placeholder' => '','class'=>'form-control']) !!}
  	                </div>

  	                <div class="form-group col-md-9">
  	                {!! Form::label('especialidades','Especialidades') !!}
  	                 {!! Form::select('especialidades[]',$especialidades,null,['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione','multiple' => 'true' ]) !!}
  	              	</div>
	              <!-- /.form-group -->
              	</div>

            	<div class="col-md-12">
               		<div class="form-group col-md-4">
					 	{!! Form::label('firma','Firma digital ( sugerido 360x120 pixeles )') !!}
					    {!! Form::file('firma', old('firma'),['class'=>'form-control']) !!}
				    </div>
    			</div>

    			<div class="col-md-12">
               		<div class="form-group col-md-3">
					 	{!! Form::label('banner','Banner ( sugerido 1080x170 pixeles )') !!}
					    {!! Form::file('banner', old('banner'),['class'=>'form-control']) !!}
				    </div>
    			</div>

 				<div class="col-md-12">
		            <div class="box-footer">
	              		  <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
	              		  <button type="reset" class="btn btn-default btn-sm">Reset</button>
	              	</div>
	            </div>

            {!! Form::close() !!}
           
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
@endsection

@section('javascript')

 <script>

   $('#pais_id').change(function(e) {
        console.log(e);
        var pais_id = e.target.value;
         $.get("{{ url('getDataDepartamantos') }}/"+pais_id, function(data) {
              $('#departamento_id').empty();
              $('#departamento_id').append('<option value="0">Seleccione una opción</option>');
               $.each(data, function(i, objeto) {
                  if(objeto.pais_id==pais_id){
                    $('#departamento_id').append('<option value="'+objeto.id+'">'+objeto.descripcion+'</option>');
                  }
               });
          });
      });

      $('#departamento_id').change(function(e) {
        console.log(e);
        var departamento_id = e.target.value;
         $.get("{{ url('getDataMunicipios') }}/"+departamento_id, function(data) {
              $('#municipio_id').empty();
              $('#municipio_id').append('<option value="0">Seleccione una opción</option>');
               $.each(data, function(i, objeto) {
                  if(objeto.departamento_id==departamento_id){
                    $('#municipio_id').append('<option value="'+objeto.id+'">'+objeto.descripcion+'</option>');
                  }
               });
          });
      });
 </script>
 @endsection
