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
                {!! Form::open(['class' => '','method' => 'POST','route' => 'especialidades.store','role' => 'form']) !!}
                <div class="col-md-12">
                    <div class="form-group col-md-3">
                        {!! Form::label('tipo_examen_id','Tipo de Examen') !!}
                        {!! Form::select('tipo_examen_id',$combos['tipo_examenes'], old('tipo_examen_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>

                    <div class="form-group col-md-9">
                        {!! Form::label('empresa','Empresa') !!}
                        {!! Form::text('empresa',old('empresa'),['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        {!! Form::label('escolaridad_id','Escolaridad') !!}
                        {!! Form::select('escolaridad_id',$combos['escolaridades'], old('escolaridad_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('numerohijos','Nro. Hijos') !!}
                        {!! Form::text('numerohijos',old('numerohijos'),['placeholder' => '','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('numeropersonascargo','Nro. Personas') !!}
                        {!! Form::text('numeropersonascargo',old('numeropersonascargo'),['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                </div>


               <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" data-toggle="modal" href="#myAlert3" class="btn btn-primary btn-sm open-modal">Actualizar</button>
                    </div>
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
                    <p>Esta seguro que desea continuar con la apertura de la historia ocupacional...? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <a  class="btnsi"><button type="button" class="btn btn-primary">Si</button></a>
                </div>
            </div>
        </div>
    </div>
 @endsection