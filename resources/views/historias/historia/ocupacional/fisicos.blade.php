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
   <div class="box box-default">
        <div class="box-header with-border">
            <div class="box-header">
                <a href="{{ route('historias.index') }}" class="btn btn-default btn-sm">Ver Historias de pacientes</a>
                <a href="{{ route('historias.historia',[$paciente->id,'ocupacional',$medico->id]) }}" class="btn btn-default btn-sm ">Ver lista de Historias de {{ $paciente->user->primernombre.' '.$paciente->user->primerapellido }}</a>
            </div>
            <div class="box-header">
           
                <div class="col-md-12 no-padding">
                    <div class="form-group col-md-1">
                        <img class='profile-user-img img-responsive' src="{{ asset('images/users/'.$paciente->user->imagen) }}" />
                    </div>
                </div>
               <div class="form-group col-md-12">
                    <h3 class="box-title"><b>Paciente:</b> {{ $paciente->user->primernombre.' '.$paciente->user->segundonombre.' '.$paciente->user->primerapellido.' '.$paciente->user->segundoapellido.' : '.$paciente->user->tipodocumento.' '.$paciente->user->numerodocumento }}</h3>
                </div>    
                <div class="form-group col-md-12">
                    <h3 class="box-title"><b>Médico:</b> {{ $medico->user->primernombre.' '.$medico->user->segundonombre.' '.$medico->user->primerapellido.' '.$medico->user->segundoapellido.' : '.$medico->user->tipodocumento.' '.$medico->user->numerodocumento }}</h3>
                </div>
            </div>  
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>

            <a href="{{ route('historias.ocupacional.edit',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Datos del Paciente</a>

            <a href="{{ route('historias.ocupacional.antecedentes',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Antecedentes Ocupacionales</a>

            <a href="{{ route('historias.ocupacional.patologias',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Antecedentes Patológicos</a>

            <a href="{{ route('historias.ocupacional.actual',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Información Ocupacional Actual</a>

            <a href="{{ route('historias.ocupacional.fisicos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Examen Físico</a>

            <a href="{{ route('historias.ocupacional.examenes',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Exámenes de laboratorio</a>

            <a href="{{ route('historias.ocupacional.diagnosticos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Diagnóstico médico</a>
        </div>
    </div>

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
    <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Exámenes Ocupacionales</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
             {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.fisicos.store_exploracion',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
               <div class="col-md-12">
                    <div class="box-body table-responsive" >
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo de Examen</th>
                                    <th class="text-center">Normal/Anormal</th>
                                    <th class="text-center col-md-5">Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($combos['examenes_ocupacionales'] as $tipo_organo)
                                @foreach($tipo_organo['organos'] as $organo)

                                <tr>
                                    <td><strong>{{ $tipo_organo['descripcion'] }}</strong> > {{ $organo['descripcion'] }}</td>

                                    
                                    <td class="text-center">
                                         {!! Form::checkbox('input()',$organo['id'],$organo['check'],['class'=>'form-control flat-red input']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text($organo['id'],$organo['resultado'],['placeholder' => '','class'=>'form-control','style' => 'width: 100%','id' => $organo['id'], $organo['disabled'] ]) !!}
                                    </td>
                                 
                                </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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

    <!--****************Prediagnóstico Visual****************-->
    <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Prediagnóstico Visual</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.fisicos.store_visual',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
               <div class="col-md-12">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo de Examen</th>
                                    <th class="text-center">Normal/Anormal</th>
                                    <th class="text-center col-md-7">Descripción</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($combos['examenes_visuales'] as $examenes_visuales)

                                @foreach($examenes_visuales['examen_visuales'] as $examen_visual)

                                <tr>
                                    <td><strong>{{ $examenes_visuales['descripcion'] }}</strong> > {{ $examen_visual['descripcion'] }}</td>

                                    
                                    <td class="text-center">
                                         {!! Form::checkbox('input()',$examen_visual['id'],$examen_visual['check'],['class'=>'form-control flat-red input2']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text($examen_visual['id'],$examen_visual['observacion'],['placeholder' => '','class'=>'form-control','style' => 'width: 100%','id' => 'ob_'.$examen_visual['id'], $examen_visual['disabled'] ]) !!}
                                    </td>
                                 
                                </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm open-modal">Actualizar</button>
                    </div>
                </div>
                 {!! Form::close() !!}
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