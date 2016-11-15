@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Examen Físico</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ocupacional',$medico->id]) }}">Examen Físico</a></li>
        <li class="active">Examen Físico</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ocupacional/cabecera')

<!--****************Información Ocupacional Actual****************-->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Examen Físico</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('flash::message')
            <div class="row">
                {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.fisicos.store',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('peso','Peso') !!}
                        {!! Form::text('peso',number_format($datos['peso'],2),['placeholder' => '0.00','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-2">
                        {!! Form::label('talla','Talla') !!}
                        {!! Form::text('talla',number_format($datos['talla'],2),['placeholder' => '0.00','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-2">
                        {!! Form::label('imc','IMC') !!}
                        {!! Form::text('imc',number_format($datos['imc'],2),['placeholder' => '','class'=>'form-control','readonly'=>'readonly']) !!}
                    </div>
                </div>
                <div class="col-md-12">

                    <div class="form-group col-md-2">
                        {!! Form::label('ta','TA') !!}
                        {!! Form::text('ta',$datos['ta'],['placeholder' => '###/###','class'=>'form-control']) !!}
                    </div>

                     <div class="form-group col-md-2">
                        {!! Form::label('fc','FC') !!}
                        {!! Form::text('fc',$datos['fc'],['placeholder' => '###/min','class'=>'form-control']) !!}
                    </div>

                     <div class="form-group col-md-2">
                        {!! Form::label('fr','FR') !!}
                        {!! Form::text('fr',$datos['fr'],['placeholder' => '###/min','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-3">
                        {!! Form::label('lateralidad_id','Lateralidad') !!}
                        {!! Form::select('lateralidad_id',$combos['lateralidades'], $datos['lateralidad_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
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

    <!--****************Exámenes Ocupacionales****************-->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Exámenes Ocupacionales</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        
            <div class="row">
                
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo de Examen</th>
                                    <th>Observación</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datos['exploraciones'] as $exploracion)
                                 <tr>
                                    <td>{{ $exploracion->organo->tipo_organo->descripcion }} > {{ $exploracion->organo->descripcion }}</td>
                                    <td>{{ $exploracion->resultado }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ocupacional.fisicos.destroy_exploracion',[$paciente->id,$historia_ocupacional->id,$exploracion->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="box-footer">
                            <button type="button" data-toggle="modal" href="#myAlert2" class="btn btn-primary btn-sm open-modal">Agregar Anomalía</button>
                        </div>
                </div>
                
            </div>
            <!-- /.col -->
        </div>
          <!-- /.row -->
    </div>

     <div class="modal fade"  id="myAlert2" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregando Anomalía</h4>
                </div>
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.fisicos.store_exploracion',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('organo_id','Diagnóstico') !!}
                            {!! Form::select('organo_id',$combos['organos'], old('organo_id'),['class' => 'form-control select2','style' => 'width: 100%']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('resultado','Observación') !!}
                            {!! Form::textarea('resultado',old('resultado'),['placeholder' => 'Observación general','class'=>'form-control','rows'=>'3']) !!}
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

    <!--****************Prediagnóstico Visual****************-->
   <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Prediagnóstico Visual</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        
            <div class="row">
                
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Examen Visual</th>
                                    <th  class="text-center">Ojo</th>
                                    <th>Observación</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datos['visuales'] as $visual)
                                 <tr>
                                    <td>{{ $visual->examen_visual->tipo_examen_visual->descripcion}}</td>
                                    <td  class="text-center">{{ $visual->examen_visual->ojo->descripcion}}</td>
                                    <td>{{ $visual->descripcion }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ocupacional.fisicos.destroy_visual',[$paciente->id,$historia_ocupacional->id,$visual->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="box-footer">
                            <button type="button" data-toggle="modal" href="#myAlert3" class="btn btn-primary btn-sm open-modal">Agregar Anomalía Visual</button>
                        </div>
                </div>
                
            </div>
            <!-- /.col -->
        </div>
          <!-- /.row -->
    </div>


     <div class="modal fade"  id="myAlert3" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregando Anomalía Visual</h4>
                </div>
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.fisicos.store_visual',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('examen_visual_id','Tipo de Examen') !!}
                            {!! Form::select('examen_visual_id',$combos['examen_visuales'], old('examen_visual_id'),['class' => 'form-control select2','style' => 'width: 100%']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('descripcion','Observación') !!}
                            {!! Form::textarea('descripcion',old('descripcion'),['placeholder' => 'Observación general','class'=>'form-control','rows'=>'3']) !!}
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
<script >
  $('.input').on('ifChecked', function(event){

         $('#'+event.target.value).prop('disabled', false);
        $('#'+event.target.value).focus();
   });

  $('.input').on('ifUnchecked', function(event){
        $('#'+event.target.value).prop('disabled', true);
        $('#'+event.target.value).val('');
   });


  $('.input2').on('ifChecked', function(event){

         $('#ob_'+event.target.value).prop('disabled', false);
        $('#ob_'+event.target.value).focus();
   });

  $('.input2').on('ifUnchecked', function(event){
        $('#ob_'+event.target.value).prop('disabled', true);
        $('#ob_'+event.target.value).val('');
   });

</script> 
@endsection