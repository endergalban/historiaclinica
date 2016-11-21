@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Historias eliminadas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Historias</a></li>
        <li class="active"><a href="#">Historias eliminadas</a></li>
      </ol>
@endsection

@section('content')
   <div class="row">
        <div class="col-xs-12">
         	<div class="box">
	            <!-- /.box-header -->
	          
	            <div class="box-body table-responsive">
			  		@include('flash::message')
	              	<table id="example2" class="table table-bordered table-hover">
				 		<thead>
							<tr >
								<th>Médico</th>
								<th>Paciente</th>
								<th class="text-center">Especialidad</th>
								<th class="text-center">Fecha de Creación</th>
								<th class="text-center">Fecha de Eliminación</th>
								<th class="text-center">Acción</th>
							</tr>
				   		</thead>
						  	<tbody>
								@foreach( $Medico_pacientes as $medico_paciente )
								<tr>
									<td>{{ $medico_paciente->medico->user->primernombre.' '.$medico_paciente->medico->user->primerapellido.' '.$medico_paciente->medico->user->tipodocumento.' '.$medico_paciente->medico->user->numerodocumento }}</td>
									<td>{{ $medico_paciente->paciente->user->primernombre.' '.$medico_paciente->paciente->user->primerapellido.' '.$medico_paciente->paciente->user->tipodocumento.' '.$medico_paciente->paciente->user->numerodocumento }}</td>
									
								
									<td class="text-center">{{ $medico_paciente->especialidad->descripcion }}</td>
									<td class="text-center">{{ date("d/m/Y h:m:s", strtotime($medico_paciente->created_at)) }}</td>
									<td class="text-center">{{ date("d/m/Y h:m:s", strtotime($medico_paciente->deleted_at)) }}</td>
									<td class="text-center">
									<a data-toggle="modal" data-url="{{ route('historias.restaurar',$medico_paciente->id) }}" class="open-modal" href="#myAlert"><span class="label label-success">Restaurar</span></a>
									</td>
								</tr>
								@endforeach
						  	</tbody>
					</table>
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
