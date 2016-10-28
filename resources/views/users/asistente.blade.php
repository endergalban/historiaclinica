@extends('layouts.main')

@section('content-header')
     <h1>
        Usuarios
        <small>Editar información del asistente</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('users.index') }}">Usuarios</a></li>
        <li class="active">Editar información del asistente</li>
      </ol>
@endsection

@section('content')

  <div class="box box-default">
      <div class="box-header with-border">

    			<div class="box-header">
    				  <a href="{{ route('users.index') }}"><button type="submit" class="btn btn-default btn-sm">Ver lista de usuarios</button></a>
    			</div>
          
        	<div class="box-tools pull-right">
        		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        	</div>
      </div>
        <!-- /.box-header -->
        <div class="box-body">
    
        @include('flash::message')
          <div class="row">
          {!! Form::open(['class' => '','method' => 'put','route' => ['users.updateroleasistente',$asistente],'role' => 'form','files' => true]) !!}

            
               <div class=col-md-12>
                  <div class="form-group col-md-1">
                    <img class='profile-user-img img-responsive' src="{{ asset('images/users/'.$asistente->user->imagen) }}" />
                  </div>
              </div>
            

              <div class=col-md-12>
                <div class="form-group col-md-12">
                    <h3 >{{ $asistente->user->primernombre.' '.$asistente->user->segundonombre.' '.$asistente->user->primerapellido.' '.$asistente->user->segundoapellido.' : '.$asistente->user->tipodocumento.' '.$asistente->user->numerodocumento }}</h3>
                </div>
              </div>
              
             


              <div class="col-md-12">
	            	
  	               <div class="form-group col-md-12">
  	                {!! Form::label('medicos','Medicos') !!}
  	                 {!! Form::select('medicos[]',$medicos, $asistente_medico,['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione','multiple' => 'true' ]) !!}
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