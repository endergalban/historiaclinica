@extends('layouts.main')

@section('content-header')
      <h1>
        Perfil de Usuario
      </h1>
      <ol class="breadcrumb">
         <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
       	 <li><a href="{{ route('perfil.index') }}">Prefil de usuario</a></li>
      </ol>
@endsection

@section('content')
<div class="row">
        <div class="col-md-3">
 <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
   <img class="profile-user-img img-responsive img-circle" src="{{ asset('images/users/'.Auth::user()->imagen) }}" alt="Imagen de perfil">

              <h3 class="profile-username text-center">{{ Auth::user()->primernombre.' '.Auth::user()->segundonombre.' '.Auth::user()->primerapellido.' '.Auth::user()->segundonombre }}</h3>

              <p class="text-muted text-center">{{ Auth::user()->ocupacion }}</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>DNI:</b> <a class="pull-right">{{ Auth::user()->tipodocumento.' '.Auth::user()->numerodocumento }}</a>
                </li>
                <li class="list-group-item">
                  <b>Email:</b> <a class="pull-right">{{ Auth::user()->email }}</a>
                </li>
                <li class="list-group-item">
                  <b>Teléfono:</b> <a class="pull-right">{{ Auth::user()->telefono }}</a>
                </li>
                
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

            <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Sistema</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-history margin-r-5"></i>Usuario desde</strong>

              <p class="text-muted">
                {{ Auth::user()->created_at->diffForHumans() }}
              </p>

              <hr>


              <strong><i class="fa fa-user margin-r-5"></i> Roles</strong>

              <p>
                @foreach(Auth::user()->roles()->get() as $role)
               		 <span class="label label-info">{{ $role->descripcion }}</span>
                @endforeach
                
              </p>

              <hr>

                 <strong><i class="fa fa-pencil margin-r-5"></i> Firma</strong>

                @if(Auth::user()->firma != '')
				
					 	<img class='profile-user-img img-responsive' src="{{ asset('images/firmas/'.Auth::user()->firma)}}" />
				@else
				<p class="text-center">N/A</p>
				@endif
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>



 
	<div class="col-md-9">
		<div class="box box-default">
        <div class="box-header with-border">
			<div class="box-header">
				  <h3 class="box-title">Cambio de Datos</a>
			</div>
          	<div class="box-tools pull-right">
          		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          	</div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        @include('flash::message')
          <div class="row">
           {!! Form::open(['class' => '','method' => 'PUT','route' => ['perfil.update',Auth::user()->id],'role' => 'form','files' => true]) !!}
           
          		
               
				<div class="col-md-12">
	                <div class="form-group col-md-4">
	            	  {!! Form::label('password','Password') !!}
	                  {!! Form::password('password',['placeholder' => '','class'=>'form-control']) !!}
	                </div>
	              <!-- /.form-group -->
	            </div>

	            <div class="col-md-12">
	                <div class="form-group col-md-4">
	            	  {!! Form::label('password_confirmation','Comfirmación') !!}
	                  {!! Form::password('password_confirmation',['placeholder' => '','class'=>'form-control']) !!}
	                </div>
	              <!-- /.form-group -->
	            </div>

	            <div class="col-md-12">
               		<div class="form-group col-md-3">
					 	{!! Form::label('imagen','Imagen de usuario') !!}
					    {!! Form::file('imagen', null,['class'=>'form-control']) !!}
				    </div>
				</div>
 				<div class="col-md-12">
				    <div class="form-group col-md-3">
					 	{!! Form::label('firma','Firma') !!}
					    {!! Form::file('firma', null,['class'=>'form-control']) !!}
				    </div>
    			</div>
	             
 				<div class="col-md-12">
		            <div class="box-footer">
	              		  <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
	              		  
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
    </div>
              <!-- /.tab-pane -->
      		      
	</div>
</div>      
@endsection
