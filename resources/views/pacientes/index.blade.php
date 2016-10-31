




	
					
						
						
										<a data-toggle="modal" data-url="{{ route('pacientes.destroy',$user->id) }}" class=open-modal label label-danger" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
										<a href="{{ route('historias.index',$user->id) }}"><span class="label label-info">Historia</span></a>
										<a href="{{ route('pacientes.edit',$user->id) }}" ><span class="label label-warning">Editar</span></a>
										<a href="{{ route('pacientes.show',$user->id) }}"><span class="label label-primary">Mostrar</span></a>
									</td>
									<td class="text-center">
									<td></td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->primerapellido.' '.$user->primernombre }}</td>
									<td>{{ $user->tipodocumento.' '.$user->numerodocumento }}</td>
								</tr>
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								<th class="text-center">Acción</th>
								<th>Email</th>
								<th>Identificación</th>
								<th>Nombre</th>
								<tr>
								@endforeach
								@foreach( $users as $user )
							</div>
							</tr>
							<div class="input-group-btn">
							<input type="text" name="search" name="search" class="form-control" placeholder="Buscar...">
							<tr >
						  	</tbody>
						  	<tbody>
						</div>
						<div class="input-group input-group-sm pull-right" style="width: 250px;">
					</div>
					</table>
					<a href="{{ route('pacientes.create') }}" class="btn btn-default btn-sm" >Crear nuevo paciente</a>
					<div class="box-tools ">
					{!! Form::close() !!}
					{!! Form::open(['method' => 'GET','route' => ['pacientes.index'],'role' => 'form','class' => '']) !!}
					{{ $users->links() }}
				 		<thead>
				   		</thead>
				</div>
			</div>
		  		</div>
	 	</div>
	           		@include('flash::message')
	              	<table id="example2" class="table table-bordered table-hover">
	            <!-- /.box-header -->
	            <div class="box-body table-responsive">
	  <div class="modal fade"  id="myAlert" tabindex="-1">
	</div>
     
         		 <div class="box-header">
         	<div class="box">
              	<a  class="btnsi"><button type="button" class="btn btn-primary">Si</button></a>
               	<p>Esta seguro que desea continuar con la operación...? </p>
                  <span aria-hidden="true">&times;</span></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <h4 class="modal-title">Confirmación</h4>
              </div>
              </div>
              </div>
              <div class="modal-body">
              <div class="modal-footer">
              <div class="modal-header">
            <!-- /.modal-content -->
            </div>
            <div class="modal-content">
          <!-- /.modal-dialog -->
          </div>
          <div class="modal-dialog">
        <!-- /.modal -->
        </div>
        <div class="col-xs-12">
        <li class="active"><a href="#">Pacientes</a></li>
        <li><a href="#"><i class="fa fa-home"></i> Escritorio</a></li>
        <small>Registros almacenados</small>
        Pacientes
      </h1>
      </ol>
      <ol class="breadcrumb">
     <h1>
   <div class="row">
@endsection
@endsection
@extends('layouts.main')
@section('content')
@section('content-header')