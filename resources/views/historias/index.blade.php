@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Pacientes almacenados</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Escritorio</a></li>
        <li class="active"><a href="#">Historias</a></li>
      </ol>
@endsection

@section('content')
   <div class="row">
        <div class="col-xs-12">
         @include('flash::message')
         	<div class="box">

         		 <div class="box-header">
					{!! Form::open(['method' => 'GET','route' => ['historias.index'],'role' => 'form','class' => '']) !!}
					<div class="box-tools ">
						<div class="form-group col-md-4">
						
						</div>
						<div class="input-group input-group-sm pull-right" style="width: 250px;">
						
							<input type="text" name="search" name="search" class="form-control" placeholder="Buscar...">
							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>

						
						</div>
					</div>
					{!! Form::close() !!}
				</div>

	            <!-- /.box-header -->
	            <div class="box-body table-responsive">
	           	
	              	<table id="example2" class="table table-bordered table-hover">
				 		<thead>
							<tr >
								<th>Identificación</th>
								<th>Nombre</th>
								<th class="text-center">Edad</th>
								<th class="text-center">Teléfono</th>
								<th class="text-center">Email</th>
								<th class="text-center">Seleccionar</th>
							</tr>
				   		</thead>
						  	<tbody>
								@foreach( $users as $user )

								<tr>
									<td>{{ $user->tipodocumento.' '.$user->numerodocumento }}</td>
									<td>{{ $user->primernombre.' '.$user->primerapellido }}</td>
									<td class="text-center">{{ $user->fechanacimiento->diff(Carbon\Carbon::now())->format('%y') }} año(s)</td>
									<td class="text-center">{{ $user->telefono }}</td>
									<td class="text-center">{{ $user->email }}</td>
									<td class="text-center">
										<a  href="{{ route('historias.medicos',[$user->paciente->id]) }}"><i class="fa fa-search" ></i></a>
									</td>
								</tr>
								@endforeach
						  	</tbody>
					</table>
					{{ $users->links() }}
		  		</div>
					
			</div>
	 	</div>
	</div>


     
@endsection