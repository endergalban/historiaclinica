@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Exámenes</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ocupacional',$medico->id]) }}">Historia Ocupacional</a></li>
        <li class="active">Exámenes</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ocupacional/cabecera')

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Exámenes</h3>
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
                                    <th>Examen</th>
                                    <th  class="text-center">Fecha</th>
                                    <th>Resultado</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($combos['examen_laboratorios'] as $examen_laboratorio)
                                 <tr>
                                    <td>{{ $examen_laboratorio->examen }}</td>
                                    <td  class="text-center">{{ date("d/m/Y", strtotime($examen_laboratorio->fecha))  }}</td>
                                    <td>{{ $examen_laboratorio->resultado }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ocupacional.examenes.destroy',[$paciente->id,$historia_ocupacional->id,$examen_laboratorio->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" data-toggle="modal" href="#myAlert2" class="btn btn-primary btn-sm open-modal">Agregar Examen</button>
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
                    <h4 class="modal-title">Agregando Examen</h4>
                </div>
                {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.examenes.store',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('examen','Examen') !!}
                            {!! Form::text('examen',old('examen'),['placeholder' => 'Descripción del examen','class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-md-4">
                            {!! Form::label('fecha','Fecha') !!}
                            {!! Form::text('fecha',old('fecha'),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker','style'=>'position: relative; z-index: 100000']) !!}
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('resultado','Resultado') !!}
                            {!! Form::textarea('resultado',old('resultado'),['placeholder' => 'Resultado del examen realizado','class'=>'form-control','rows'=>'3']) !!}
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
        </div>
    </div>

@endsection