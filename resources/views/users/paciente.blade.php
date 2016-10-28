@extends('layouts.main')

@section('content-header')
     <h1>
        Usuarios
        <small>Editar información del paciente</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('users.index') }}">Usuarios</a></li>
        <li class="active">Editar información del paciente</li>
      </ol>
@endsection

@section('content')

  <div class="box box-default">
      <div class="box-header with-border">

    			<div class="box-header">
    				  <a href="{{ route('users.index') }}"><button type="submit" class="btn btn-default btn-sm">Ver lista de usuarios</button></a>
    			</div>
          <div class="box-header">
              <h3 class="box-title">{{ $paciente->primernombre.' '.$paciente->segundonombre.' '.$paciente->primerapellido.' '.$paciente->segundoapellido.' : '.$paciente->tipodocumento.' '.$paciente->numerodocumento }}</h3>
          </div>  
        	<div class="box-tools pull-right">
        		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        	</div>
      </div>
        <!-- /.box-header -->
        <div class="box-body">
    
        @include('flash::message')
          <div class="row">
          {!! Form::open(['class' => '','method' => 'put','route' => ['users.updaterolepaciente',$paciente->paciente->  id],'role' => 'form']) !!}
       
	           
                 <div class=col-md-12>
                    <div class="form-group col-md-1">
                      <img class='profile-user-img img-responsive' src="{{ asset('images/users/'.$paciente->imagen) }}" />
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group col-md-4">
                    {!! Form::label('paisresidencia_id','País Residencia') !!}
                       {!! Form::select('paisresidencia_id',$paises,  $residencia['paisresidencia_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>

                    <div class="form-group col-md-4">
                    {!! Form::label('departamentoresidencia_id','Departamento Residencia') !!}
                      {!! Form::select('departamentoresidencia_id',$departamentos, $residencia['departamentoresidencia_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                
                  <div class="form-group col-md-4">
                    {!! Form::label('municipioresidencia_id','Municipio Residencia') !!}
                      {!! Form::select('municipioresidencia_id',$municipios, $residencia['municipioresidencia_id'] ,['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                  <!-- /.form-group -->
                </div>

              <div class="col-md-12">
	                <div class="form-group col-md-4">
	                {!! Form::label('empresa_id','EPS') !!}
	                 {!! Form::select('empresa_id',$empresas, $paciente->paciente->empresa_id,['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione' ]) !!}
	              	</div>
                  <div class="form-group col-md-4">
                    {!! Form::label('arl_id','ARL') !!}
                     {!! Form::select('arl_id',$arls,$paciente->paciente->arl_id,['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione' ]) !!}
                    </div>
            
                <div class="form-group col-md-4">
                    {!! Form::label('afp_id','AFP') !!}
                     {!! Form::select('afp_id',$afps,$paciente->paciente->afp_id,['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione' ]) !!}
                </div>
	              <!-- /.form-group -->
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