@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Datos del Paciente</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ocupacional',$medico->id]) }}">Historia Ocupacional</a></li>
        <li class="active">Datos del Paciente</li>
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

<!--**************** Datos del Paciente **********************-->

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Datos del Paciente</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('flash::message')
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.edit.store',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="col-md-12">
                    <div class="form-group col-md-3">
                        {!! Form::label('tipo_examen_id','Tipo de Examen') !!}
                        {!! Form::select('tipo_examen_id',$combos['tipo_examenes'], $resultados['tipo_examen_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>

                    <div class="form-group col-md-9">
                        {!! Form::label('empresa','Empresa') !!}
                        {!! Form::text('empresa',$resultados['empresa'],['placeholder' => 'Nombre de la empresa donde labora','class'=>'form-control']) !!}
                    </div>
                </div>

                 <div class="col-md-12">
                    <div class="form-group col-md-4">
                        {!! Form::label('empresa_id','EPS') !!}
                         {!! Form::select('empresa_id',$combos['empresas'], $resultados['empresa_id'],['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione' ]) !!}
                        </div>
                
                    <div class="form-group col-md-4">
                        {!! Form::label('arl_id','ARL') !!}
                         {!! Form::select('arl_id',$combos['arls'], $resultados['arl_id'],['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione' ]) !!}
                        </div>
                
                    <div class="form-group col-md-4">
                        {!! Form::label('afp_id','AFP') !!}
                         {!! Form::select('afp_id',$combos['afps'], $resultados['afp_id'],['class' => 'form-control select2','style' => 'width: 100%','data-placeholder' => 'Seleccione' ]) !!}
                        </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        {!! Form::label('escolaridad_id','Escolaridad') !!}
                        {!! Form::select('escolaridad_id',$combos['escolaridades'],$resultados['escolaridad_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('numerohijos','Nro. Hijos') !!}
                        {!! Form::text('numerohijos',$resultados['numerohijos'],['placeholder' => '0','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('numeropersonascargo','Nro. Personas') !!}
                        {!! Form::text('numeropersonascargo',$resultados['numeropersonascargo'],['placeholder' => '0','class'=>'form-control']) !!}
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