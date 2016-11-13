@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Antecedentes Ocupacionales</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ocupacional',$medico->id]) }}">Historia Ocupacional</a></li>
        <li class="active">Antecedentes Ocupacionales</li>
    </ol>
@endsection

@section('content')
	@include('historias/historia/ocupacional/cabecera')

<!--****************Antecedentes Ocupacionales****************-->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Antecedentes Ocupacionales</h3>
            <div class="box-tools pull-right">
            	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
       		@include('flash::message')
          	<div class="row">
                   	<div class="col-md-12">
                	<div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                      		<thead>
                        		<tr>
    								<th>Empresa</th>
    								<th>Tiempo de Servicio</th>
    								<th>Ocupacion</th>
    								<th class="text-center">Acción</th>
                        		</tr>
                      		</thead>
                      		<tbody>
                                 @foreach($combos['antecedente_ocupacionales'] as $antecedente_ocupacional)
                                 <tr>
                                    <td>{{ $antecedente_ocupacional->empresa }}</td>
                                    <td>{{ $antecedente_ocupacional->tiemposervicio }}</td>
                                    <td>{{ $antecedente_ocupacional->ocupacion }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('historias.ocupacional.antecedentes.riesgos',[$paciente->id,$historia_ocupacional->id,$antecedente_ocupacional->id]) }}" ><span class="label label-info">Factores de Riesgos</span></a>
                                        <a href="{{ route('historias.ocupacional.antecedentes.lesiones',[$paciente->id,$historia_ocupacional->id,$antecedente_ocupacional->id]) }}" ><span class="label label-info">Lesiones</span></a>
                                        <a data-toggle="modal" data-url="{{ route('historias.ocupacional.antecedentes.destroy',[$paciente->id,$historia_ocupacional->id,$antecedente_ocupacional->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                                @endforeach
                      		</tbody>
                	   </table>
                    </div>
              	</div>
              	<div class="col-md-12">
                	<div class="box-footer">
                      	<button type="button" data-toggle="modal" href="#myAlert2" class="btn btn-primary btn-sm open-modal">Agregar Empresa</button>
                  	</div>
              	</div>
       
             </div>
            <!-- /.col -->
      	</div>
          <!-- /.row -->
    </div>
        <!-- /.box-body -->

	<div class="modal fade"  id="myAlert2" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregando Empresa</h4>
                </div>
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.antecedentes.store',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('empresa','Empresa') !!}
                            {!! Form::text('empresa',old('empresa'),['placeholder' => 'Nombre de la empresa donde laboró','class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">

                        <div class="form-group col-md-8">
                            {!! Form::label('tiemposervicio','Tiempo de Servicio') !!}
                            {!! Form::text('tiemposervicio',old('tiemposervicio'),['placeholder' => 'Tiempo que duró laborando en la empresa','class'=>'form-control']) !!}
                        </div>

                        <div class="form-group col-md-12">
                            {!! Form::label('ocupacion','Oupación') !!}
                            {!! Form::text('ocupacion',old('ocupacion'),['placeholder' => 'Nombre del cargo que ejerció en la empresa','class'=>'form-control']) !!}
                        </div>
                    
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Agregar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </div>
               {!! Form::close() !!}

                
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