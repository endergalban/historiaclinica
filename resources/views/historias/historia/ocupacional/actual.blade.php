@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Información Ocupacional Actual</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ocupacional',$medico->id]) }}">Historia Ocupacional</a></li>
        <li class="active">Información Ocupacional Actual</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ocupacional/cabecera')

<!--****************Información Ocupacional Actual****************-->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Información Ocupacional Actual</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('flash::message')
            <div class="row">
                {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.actual.store',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}

                <div class="col-md-12">
                    <div class="form-group col-md-8">
                        {!! Form::label('empresa','Empresa') !!}
                        {!! Form::text('empresa',$historia_ocupacional->empresa,['placeholder' => '','class'=>'form-control','disabled'=>'disabled']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        {!! Form::label('cargoactual','Cargo Actual') !!}
                        {!! Form::text('cargoactual',$datos['cargoactual'],['placeholder' => 'Nombre del cargo que ejerce en la empresa','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('turno_id','Turno') !!}
                        {!! Form::select('turno_id',$combos['turnos'], $datos['turno_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('actividad_id','Actividad') !!}
                        {!! Form::select('actividad_id',$combos['actividades'], $datos['actividad_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>

                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @if($datos['mostrar_fatores'])
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Factores de Riesgos</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                   <div class="col-md-12">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo de Factor</th>
                                    <th>Descripción</th>
                                    <th>Tiempo de Exposición</th>
                                    <th>Medidas de Control</th>
                                    <th class="text-center">Acción</th>
                                <tr>
                            </thead>
                            <tbody>
                                @foreach($datos['factores'] as $factor)
                                <tr>
                                    <td>{{ $factor->factor_riesgo->tipo_factor_riesgo->descripcion }}</td>
                                    @if( $factor->factor_riesgo->descripcion == 'Otros' && $factor->otro !='' )
                                        <td>{{ $factor->otro }}</td>
                                    @else
                                        <td>{{ $factor->factor_riesgo->descripcion }}</td>
                                    @endif
                                    <td>{{ $factor->tiempoexposicion }}</td>
                                    <td>{{ $factor->medidacontrol }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ocupacional.actual.destroy_factor',[$paciente->id,$historia_ocupacional->id,$factor->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" data-toggle="modal" href="#myAlert2" class="btn btn-primary btn-sm open-modal">Agregar Factor de Riesgo</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade"  id="myAlert2" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregando Factor de Riesgo</h4>
                </div>
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.actual.store_factor',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
             
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('factor_riesgo_id','Tipo de Riesgo') !!}
                            {!! Form::select('factor_riesgo_id',$combos['factor_riesgos'], old('factor_riesgo_id'),['class' => 'form-control select2 factor_riesgo_id','style' => 'width: 100%']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('otro','Otro tipo de Riesgo') !!}
                            {!! Form::text('otro',old('otro'),['placeholder' => '','class'=>'form-control','disabled'=>'form-disabled']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-8">
                            {!! Form::label('tiempoexposicion','Tiempo de Exposición') !!}
                            {!! Form::text('tiempoexposicion',old('tiempoexposicion'),['placeholder' => 'Tiempo que duro expuesto','class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('medidacontrol','Medidas de Control') !!}
                            {!! Form::textarea('medidacontrol',old('medidacontrol'),['placeholder' => '','class'=>'form-control','rows'=>'3']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Agregar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
        </div>
    </div>
    @endif

  @endsection


@section('javascript')
<script >

$(document).on("change", ".factor_riesgo_id", function () {
    texto=$("#factor_riesgo_id option:selected").html();
    if(texto.slice(-5,-1) == 'Otro'){

        $('#otro').prop('disabled', false);
        $('#otro').focus();
    }else{
        $('#otro').val('');
        $('#otro').prop('disabled', true);
    }
});

</script>  
@endsection  