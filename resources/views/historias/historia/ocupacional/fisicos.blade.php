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
                <h3 class="box-title">{{ $paciente->user->primernombre.' '.$paciente->user->segundonombre.' '.$paciente->user->primerapellido.' '.$paciente->user->segundoapellido.' : '.$paciente->user->tipodocumento.' '.$paciente->user->numerodocumento }}</h3>
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
                {!! Form::open(['class' => '','method' => 'POST','route' => 'especialidades.store','role' => 'form']) !!}

                <div class="col-md-12">
                    <div class="form-group col-md-1">
                        {!! Form::label('peso','Peso') !!}
                        {!! Form::text('peso',old('peso'),['placeholder' => '','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-1">
                        {!! Form::label('talla','Talla') !!}
                        {!! Form::text('talla',old('talla'),['placeholder' => '','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-1">
                        {!! Form::label('imc','IMC') !!}
                        {!! Form::text('imc',old('imc'),['placeholder' => '','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-1">
                        {!! Form::label('ta','TA') !!}
                        {!! Form::text('ta',old('ta'),['placeholder' => '','class'=>'form-control']) !!}
                    </div>

                     <div class="form-group col-md-1">
                        {!! Form::label('fc','FC') !!}
                        {!! Form::text('fc',old('fc'),['placeholder' => '','class'=>'form-control']) !!}
                    </div>

                     <div class="form-group col-md-1">
                        {!! Form::label('fr','FR') !!}
                        {!! Form::text('fr',old('fr'),['placeholder' => '','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-2">
                        {!! Form::label('lateralidad_id','Lateralidad') !!}
                        {!! Form::select('lateralidad_id',$combos['lateralidades'], old('lateralidad_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>

                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" class="btn btn-primary btn-sm">Actualizar</button>
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
            @include('flash::message')
            <div class="row">
               <div class="col-md-12">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo de Examen</th>
                                    <th class="text-center">Chequeo</th>
                                    <th class="text-center col-md-7">Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($combos['examenes_ocupacionales'] as $tipo_organo)
                                @foreach($tipo_organo['organos'] as $organo)
                                <tr>
                                    <td><strong>{{ $tipo_organo['descripcion'] }}</strong> > {{ $organo['descripcion'] }}</td>
                                    <td class="text-center">
                                         {!! Form::checkbox('id_organo()',$organo['id'],false,['class'=>'form-control flat-red']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('resultado()',old('resultado()'),['placeholder' => '','class'=>'form-control','style' => 'width: 100%']) !!}
                                    </td>
                                   

                                </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
            @include('flash::message')
            <div class="row">
               <div class="col-md-12">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo de Examen</th>
                                    <th>Ojo</th>
                                    <th>Descripción</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" data-toggle="modal" href="#myAlert2" class="btn btn-primary btn-sm open-modal">Agregar Diagnóstico</button>
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
                <div class="modal-body">
                  
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('examen_visual_id','Tipo de Examen') !!}
                            {!! Form::select('examen_visual_id',$combos['examen_visuales'],old('examen_visual_id'),['placeholder' => '','class'=>'form-control']) !!}
                        </div>
                    </div>
                   
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('descripcion','Observación') !!}
                            {!! Form::textarea('descripcion',old('descripcion'),['placeholder' => '','class'=>'form-control','rows'=>'3']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Agregar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

  @endsection