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
	           	
	              	<table id="example2" class="table table-bordered">
				 		<thead>
							<tr >
								<th>Identificación</th>
								<th>Nombre</th>
								<th class="text-center">Edad</th>
								<th class="text-center">Teléfono</th>
								<th class="text-center">Seleccionar</th>
								<th>Historias Creadas</th>
								
							</tr>
				   		</thead>
						  	<tbody>
								@foreach( $users as $user )

								<tr>
									<td>{{ $user->tipodocumento.' '.$user->numerodocumento }}</td>
									<td>{{ $user->primernombre.' '.$user->primerapellido }}</td>
									<td class="text-center">{{ $user->fechanacimiento->diff(Carbon\Carbon::now())->format('%y') }} año(s)</td>
									<td class="text-center">{{ $user->telefono }}</td>
									<td class="text-center">
										<a  class="open-modal label label-success" href="{{ route('historias.medicos',[$user->paciente->id]) }}">Ver Historia</a>
									</td>
									<td>
										<table id="example2" class="table table-bordered table-hover">
										
											@foreach( $user->paciente->medico_pacientes as $medico )
										  		<tr>
											  		<td>{{$medico->medico->user->primernombre.' '.$medico->medico->user->primerapellido}}</td>
											  		<td> {{$medico->load('especialidad')->especialidad->descripcion }}</td>
											  		<td class="text-center"> 
											  			@if( $acciones==true )
											  				<a data-toggle="modal" data-url="{{ route('historias.destroy',$medico->id) }}" class=open-modal label label-danger" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
											  			@else
															<a  href="#"><span class="label label-default">Eliminar</span></a>
											  			@endif
											  		</td>
											  	</tr>
										  	@endforeach
										  
										
										</table>
									</td>
									
								</tr>
								@endforeach
						  	</tbody>
					</table>
					{{ $users->links() }}
		  		</div>
				@if( $acciones==true )
		  		 <div class="box-footer">
					<a class="btn btn-default btn-sm pull-right" href="{{ route('historias.reciclaje') }}" >Ver Papelera</a>
		        </div>
		        @endif
					
			</div>
	 	</div>
	</div>


 <div class="modal fade"  id="myAlert" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmación</h4>
              </div>
              <div class="modal-body">
               	<p>Esta seguro que desea continuar con la operación...? </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
              	<a  class="btnsi"><button type="button" class="btn btn-primary">Si</button></a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

     
@endsection