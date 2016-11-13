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
    
    @include('historias/historia/ocupacional/cabecera')

<!--**************** RECOMENDACIONES**********************-->

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Recomendaciones</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('flash::message')
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.recomendaciones.store',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="col-md-12">
                   

                    <div class="form-group col-md-12">
                 
                        {!! Form::textarea('recomendaciones',$historia_ocupacional->recomendaciones,['placeholder' => 'Recomendaciones y observaciones','class'=>'form-control','rows'=>'6']) !!}
                    </div>
                </div>

                
               <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm open-modal">Guardar</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
 @endsection