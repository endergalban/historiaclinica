@extends('layouts.main')

@section('content-header')
     <h1>
        Pacientes
        <small>Crear nuevo paciente</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('pacientes.index') }}">Pacientes</a></li>
        <li class="active">Crear nuevo paciente</li>
      </ol>
@endsection

@section('content')

  <div class="box box-default">
        <div class="box-header with-border">
			<div class="box-header">
				  <a href="{{ route('pacientes.index') }}"><button type="submit" class="btn btn-default btn-sm">Ver lista de pacientes</button></a>
			</div>
          	<div class="box-tools pull-right">
          		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          	</div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        @include('flash::message')
          <div class="row">
          	{!! Form::open(['class' => '','method' => 'POST','route' => 'pacientes.store','role' => 'form','files' => true]) !!}

      			
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

	                   ], old('activo'),['class' => 'form-control select2','style' => 'width: 100%']) !!}
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
	                  {!! Form::text('ocupacion',old('ocupacion'),['placeholder' => '','class'=>'form-control']) !!}
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
	            	<div class="form-group col-md-4">
	            	  {!! Form::label('paisresidencia_id','País Residencia') !!}
	                   {!! Form::select('paisresidencia_id',$residencia['paises'], old('paisresidencia_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
	                </div>

	                <div class="form-group col-md-4">
	            	  {!! Form::label('departamentoresidencia_id','Departamento Residencia') !!}
	                  {!! Form::select('departamentoresidencia_id',$residencia['departamentos'], old('departamentoresidencia_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
	                </div>
	            
	            	<div class="form-group col-md-4">
	            	  {!! Form::label('municipioresidencia_id','Municipio Residencia') !!}
	                  {!! Form::select('municipioresidencia_id',$residencia['municipios'], old('municipioresidencia_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
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
		            <div class="form-group col-md-4">
		                {!! Form::label('empresa_id','EPS') !!}
		                 {!! Form::select('empresa_id',$empresas, old('empresa_id'),['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione' ]) !!}
		              	</div>
		       
		            <div class="form-group col-md-4">
		                {!! Form::label('arl_id','ARL') !!}
		                 {!! Form::select('arl_id',$arls, old('arl_id'),['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione' ]) !!}
		              	</div>
		        
		            <div class="form-group col-md-4">
		                {!! Form::label('afp_id','AFP') !!}
		                 {!! Form::select('afp_id',$afps, old('arl_id'),['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione' ]) !!}
		            </div>
		        </div>

             	<div class="col-md-12">
               		<div class="form-group col-md-3">
					 	{!! Form::label('firma','Firma digital') !!}
					    {!! Form::file('firma', old('firma'),['class'=>'form-control']) !!}
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

	$('.datepicker').daterangepicker({
        singleDatePicker: true,
        format: 'DD-MM-YYYY',
        calender_style: "picker_2",
        showDropdowns: true,
         "singleDatePicker": true,
          "showDropdowns": true,
          "showWeekNumbers": true,
          "locale": {
            "format": 'DD/MM/YYYY',
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "Desde",
            "toLabel": "hasta",
            "customRangeLabel": "Custom",
            "weekLabel": "S",
            "daysOfWeek": ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa' ],
            "monthNames": ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            "firstDay": 1
          },
          "showCustomRangeLabel": false

      }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
      });

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

      $('#paisresidencia_id').change(function(e) {
        console.log(e);
        var pais_id = e.target.value;
         $.get("{{ url('getDataDepartamantos') }}/"+pais_id, function(data) {
              $('#departamentoresidencia_id').empty();
              $('#departamentoresidencia_id').append('<option value="0">Seleccione una opción</option>');
               $.each(data, function(i, objeto) {
                 
                    $('#departamentoresidencia_id').append('<option value="'+objeto.id+'">'+objeto.descripcion+'</option>');
                  
               });
          });
      });

      $('#departamentoresidencia_id').change(function(e) {
        console.log(e);
        var departamento_id = e.target.value;
         $.get("{{ url('getDataMunicipios') }}/"+departamento_id, function(data) {
              $('#municipioresidencia_id').empty();
              $('#municipioresidencia_id').append('<option value="0">Seleccione una opción</option>');
               $.each(data, function(i, objeto) {
                  
                    $('#municipioresidencia_id').append('<option value="'+objeto.id+'">'+objeto.descripcion+'</option>');
                  
               });
          });
      });
 </script>
 @endsection
