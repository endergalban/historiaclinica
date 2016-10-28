@extends('layouts.main')

@section('content-header')
     <h1>
        Especialidades
        <small>Crear nueva especialidad</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('especialidades.index') }}">Especialidades</a></li>
        <li class="active">Crear nueva especialidad</li>
      </ol>
@endsection

@section('content')

  <div class="box box-default">
        <div class="box-header with-border">
			<div class="box-header">
				  <a href="{{ route('especialidades.index') }}"><button type="submit" class="btn btn-default btn-sm">Ver lista de especialidades</button></a>
			</div>
          	<div class="box-tools pull-right">
          		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          	</div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        @include('flash::message')
          <div class="row">
          	{!! Form::open(['class' => '','method' => 'POST','route' => 'especialidades.store','role' => 'form']) !!}

	          	<div class="col-md-12">
	                <div class="form-group col-md-9">
	            	  {!! Form::label('descripcion','Descripción') !!}
	                  {!! Form::text('descripcion',old('descripcion'),['placeholder' => '','class'=>'form-control']) !!}
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
