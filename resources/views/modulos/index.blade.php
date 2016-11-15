@extends('layouts.main')

@section('content-header')
     <h1>
        Módulos
        <small>Registros almacenados</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Escritorio</a></li>
        <li class="active"><a href="#">Módulos</a></li>
      </ol>
@endsection

@section('content')
   <div class="row">
        <div class="col-xs-12">
         	<div class="box">
               <div class="box-header">
					{!! Form::open(['method' => 'GET','route' => ['modulos.index'],'role' => 'form','class' => '']) !!}
					<div class="box-tools ">
					<a href="{{ route('modulos.create') }}"  class="btn btn-default btn-sm" >Crear nuevo módulo </a>
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
			  		@include('flash::message')
	              	<table id="example2" class="table table-bordered table-hover">
				 		<thead>
							<tr >
								<th class="text-center">Order</th>
								<th class="text-center">icono</th>
								<th>Nombre</th>
								<th>Site</th>
								<th class="text-center">Visible</th>
								<th>Roles</th>
								<th class="text-center">Acción</th>
							</tr>
				   		</thead>
						  	<tbody>
								@foreach( $modulos as $modulo )
								<tr>
									<td class="text-center">{{ $modulo->orden }}</td>
									<td class="text-center"><i class="fa {{ $modulo->icono }}"></i></td>
									<td>{{ $modulo->descripcion }}</td>
									<td>{{ $modulo->site }}</td>
									@if($modulo->visible == 1)
										<td class="text-center">Si</td>
									@else
										<td class="text-center">No</td>
									@endif
									<td>	
									@foreach( $modulo->roles as $role )
										<a  href="#"><span class="label label-default">{{ $role->descripcion }}</span></a>
									@endforeach	
									</td>
									<td class="text-center">
										<a href="{{ route('modulos.edit',$modulo->id) }}" ><span class="label label-warning">Editar</span></a>
										<a data-toggle="modal" data-url="{{ route('modulos.destroy',$modulo->id) }}" class=open-modal label label-danger" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
									</td>
								</tr>
								@endforeach
						  	</tbody>
					</table>
					{{ $modulos->links() }}
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
