@extends('layouts.main')

@section('content-header')
     <h1>
        Usuarios
        <small>Editar información del médico</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('users.index') }}">Usuarios</a></li>
        <li class="active">Editar información del médico</li>
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
          {!! Form::open(['class' => '','method' => 'put','route' => ['users.updaterolemedico',$medico],'role' => 'form','files' => true]) !!}

            
               <div class=col-md-12>
                  <div class="form-group col-md-1">
                    <img class='profile-user-img img-responsive' src="{{ asset('images/users/'.$medico->user->imagen) }}" />
                  </div>
              </div>
            

              <div class=col-md-12>
                <div class="form-group col-md-12">
                    <h3 >{{ $medico->user->primernombre.' '.$medico->user->segundonombre.' '.$medico->user->primerapellido.' '.$medico->user->segundoapellido.' : '.$medico->user->tipodocumento.' '.$medico->user->numerodocumento }}</h3>
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="form-group col-md-12 ">
                @if(file_exists( public_path().'/images/banner/'.$medico->banner) &&  $medico->banner!='' )
                    <img class='img-responsive' src="{{ asset('images/banner/'.$medico->banner)}}" />
                @endif
                </div>
              </div>


              <div class="col-md-12">
	            	
  	                <div class="form-group col-md-3">
  	            	  {!! Form::label('registro','Nro. Registro') !!}
  	                  {!! Form::text('registro',$medico->registro,['placeholder' => '','class'=>'form-control']) !!}
  	                </div>

  	                <div class="form-group col-md-9">
  	                {!! Form::label('especialidades','Especialidades') !!}
  	                 {!! Form::select('especialidades[]',$especialidades, $especialidad_medico,['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione','multiple' => 'true' ]) !!}
  	              	</div>
	              <!-- /.form-group -->
              </div>

              <div class="col-md-12">
                  <div class="form-group col-md-3">
                  {!! Form::label('banner','Banner ( sugerido 1080x170 pixeles )') !!}
                  {!! Form::file('banner', null,['class'=>'form-control']) !!}
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