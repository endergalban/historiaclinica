@extends('layouts.main')

@section('content-header')
     <h1>
        Usuarios
        <small>Registros eliminados</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Escritorio</a></li>
        <li class="active"><a href="#">Usuarios eliminados</a></li>
      </ol>
@endsection

@section('content')
   <div class="row">
        <div class="col-xs-12">
         	<div class="box">
	            <!-- /.box-header -->
	             <div class="box-header">

					{!! Form::open(['method' => 'GET','route' => ['users.reciclaje'],'role' => 'form','class' => '']) !!}
					<div class="box-tools ">
					 <a href="{{ route('users.index') }}" class="btn btn-default btn-sm" >Volver </a>
						<div class="input-group input-group-sm pull-right" style="width: 250px;">
						
							<input type="text" name="search" name="search" class="form-control" placeholder="Buscar...">
							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>

						
						</div>
					</div>
					{!! Form::close() !!}
				</div>
	            <div class="box-body table-responsive">
			  		@include('flash::message')
	              	<table id="example2" class="table table-bordered table-hover">
				 		<thead>
							<tr >
								<th>Identificación</th>
								<th>Nombre</th>
								<th class="text-center">Fecha de Creación</th>
								<th class="text-center">Fecha de Eliminación</th>
								<th class="text-center">Acción</th>
							</tr>
				   		</thead>
						  	<tbody>
								@foreach( $users as $user )
								<tr>
									<td>{{ $user->tipodocumento.' '.$user->numerodocumento }}</td>
									<td>{{ $user->primernombre.' '.$user->primerapellido }}</td>
									<td class="text-center">{{ date("d/m/Y h:m:s", strtotime($user->created_at)) }}</td>
									<td class="text-center">{{ date("d/m/Y h:m:s", strtotime($user->deleted_at)) }}</td>
									<td class="text-center">
										
										
										<a data-toggle="modal" data-url="{{ route('users.restaurar',$user->id) }}" class="open-modal" href="#myAlert"><span class="label label-success">Restaurar</span></a>
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
