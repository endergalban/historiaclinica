@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Registros almacenados</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Escritorio</a></li>
        <li class="active"><a href="#">Historias</a></li>
      </ol>
@endsection

@section('content')
   <div class="row">
        <div class="col-xs-12">
         	<div class="box">
         		 <div class="box-header">
					{!! Form::open(['method' => 'GET','route' => ['historias.index'],'role' => 'form','class' => '']) !!}
					<div class="box-tools ">
						<div class="form-group col-md-4">
						@if(is_array($medicos))
							{!! Form::select('medico_id',$medicos,0,['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione','id' => 'medico_id' ]) !!}
						@else
							{!! Form::hidden('medico_id',$medicos,['id'=>'medico_id']) !!}
						@endif
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
	           		@include('flash::message')
	              	<table id="example2" class="table table-bordered table-hover">
				 		<thead>
							<tr >
								<th>Identificación</th>
								<th>Nombre</th>
								<th class="text-center">Fecha de Nacimiento</th>
								<th class="text-center">Historia</th>
							</tr>
				   		</thead>
						  	<tbody>
								@foreach( $users as $user )

								<tr>
									<td>{{ $user->tipodocumento.' '.$user->numerodocumento }}</td>
									<td>{{ $user->primerapellido.' '.$user->primernombre }}</td>
									<td class="text-center">{{ date("d/m/Y", strtotime($user->fechanacimiento)) }}</td>
						
									<td class="text-center">
									<a  data-url="{{ route('historias.historia',[$user->paciente->id,'ocupacional']) }}" class="open-modal2" href="#"><span class="label bg-navy">Ocupacional</span></a>
									@if( $user->genero=='Femenino')
										<a data-url="{{ route('historias.historia',[$user->paciente->id,'ginecologia']) }}" class="open-modal2" href="#"><span class="label bg-maroon">Ginecología</span></a>
									@endif
									<a  data-url="{{ route('historias.historia',[$user->paciente->id,'pediatria']) }}" class="open-modal2" href="#"><span class="label bg-teal">Pediatría</span></a>
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


@section('javascript')
<script>

$(document).on("click", ".open-modal2", function () {
       window.location.href = $(this).data('url')+'/'+ $('#medico_id').val();
});
</script>

@endsection