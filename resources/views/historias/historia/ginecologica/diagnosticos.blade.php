@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Diagnóstico Médico</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Diagnóstico Médico</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ginecologica/cabecera')


     @include('flash::message')
    <div class="box box-default ">
        <div class="box-header with-border">
            <h3 class="box-title">Análisis</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.analisis.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
                <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::textarea('analisis',$historia_ginecologica->analisis,['placeholder' => '','class'=>'form-control','rows'=>'4']) !!}
                    </div>
                </div>
                

                
               <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm open-modal">Guardar</button>
                        <a  class="btn btn-default btn-sm" target="_BLANK" href="{{ route('reporte.historia_ginecologica_indicaciones',[$historia_ginecologica->id,'analisis']) }}">Descargar</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Diagnóstico del Médico</h3>
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
                                    <th class="text-center">Código</th>
                                    <th>Nombre</th>
                                    <th>Concepto</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($combos['diagnosticos'] as $diagnostico)
                                 <tr>
                                    <td class="text-center">{{ $diagnostico->tipo_diagnostico->codigo }}</td>
                                    <td>{{ $diagnostico->tipo_diagnostico->descripcion }}</td>
                                    <td>{{ $diagnostico->concepto }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ginecologica.diagnosticos.destroy',[$paciente->id,$historia_ginecologica->id,$diagnostico->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" data-toggle="modal" href="#myAlert2" class="btn btn-primary btn-sm open-modal">Agregar Diagnóstico Médico</button>
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
                    <h4 class="modal-title">Agregando Diagnóstico Médico</h4>
                </div>
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.diagnosticos.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('tipo_diagnostico_id','Diagnóstico') !!}
                            {!! Form::select('tipo_diagnostico_id',[], old('tipo_diagnostico_id'),['class' => 'form-control js-data-example-ajax','style' => 'width: 100%']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('concepto','Concepto') !!}
                            {!! Form::textarea('concepto',old('concepto'),['placeholder' => 'Observación general','class'=>'form-control','rows'=>'3']) !!}
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
@section('javascript')
    <script>
        $("#tipo_diagnostico_id").select2({

            language: "es",
            placeholder: 'Seleccione',
            ajax: {
              url:  function (params) {
                  return '{{ url('/getTipoDiagnostico')}}/' + params.term;
                },
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
                return {
                  results: data
                };  
              },
              cache: true
            }
        });
    </script>
@endsection