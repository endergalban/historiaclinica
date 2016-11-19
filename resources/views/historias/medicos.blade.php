@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Selección de Médico</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Escritorio</a></li>
        <li class="active"><a href="#">Historias</a></li>
        <li class="active"><a href="#">Selección de Médico</a></li>
      </ol>
@endsection

@section('content')
   <div class="row">
        <div class="col-xs-12">
         	<div class="box">
         		<div class="box-header">
					<h4><b>Paciente:</b> {{ $paciente->user->primernombre.' '.$paciente->user->primerapellido }}</h4>
				</div>
         		 
	            <!-- /.box-header -->
	            <div class="box-body table-responsive">
	           
	              	<table id="example2" class="table table-bordered table-hover">
				 		<thead>
							<tr >
								<th>Identificación</th>
								<th>Médico</th>
								<th class="text-center">Registro</th>
								<th class="text-center">Email</th>
								<th class="text-center">Teléfono</th>
								<th class="text-center">Especialidad</th>
							</tr>
				   		</thead>
						  	<tbody>
								@foreach( $medicos as $medico )

								<tr>
									<td>{{ $medico->tipodocumento.' '.$medico->numerodocumento }}</td>
									<td>{{ $medico->primernombre.' '.$medico->primerapellido }}</td>
									<td class="text-center">{{$medico->medico->registro }}</td>
									<td class="text-center">{{$medico->email }}</td>
									<td class="text-center">{{$medico->telefono }}</td>
						
									<td class="text-left">

									@foreach( $medico->medico->especialidades as $especialidad )
									@if($paciente->user->genero=='Masculino')
										@if($especialidad->id!=3)
								  			<a href="{{ route('historias.historia',[$paciente->id,$especialidad->id,$medico->medico->id]) }}" ><span class="label label-primary" >{{$especialidad->descripcion}}</span></a>
								  		@endif
								  	@else
								  		<a href="{{ route('historias.historia',[$paciente->id,$especialidad->id,$medico->medico->id]) }}" ><span class="label label-primary" >{{$especialidad->descripcion}}</span></a>
								  	@endif
									@endforeach	
									</td>
								</tr>
								@endforeach
						  	</tbody>
					</table>
			
		  		</div>
					
			</div>
	 	</div>
	</div>


     
@endsection


@section('javascript')
<script>

$(document).on("click", ".open-modal2", function () {
       window.location.href = $(this).data('url')+'/'+ $('#medico_id').val()+'';
});
</script>

@endsection