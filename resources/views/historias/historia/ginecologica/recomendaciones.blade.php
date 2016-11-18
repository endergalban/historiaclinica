@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Recomendaciones</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Recomendaciones</li>
    </ol>
@endsection

@section('content')
    
    @include('historias/historia/ginecologica/cabecera')

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
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.recomendaciones.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
                <div class="col-md-12">
                   

                    <div class="form-group col-md-12">
                 
                        {!! Form::textarea('recomendaciones',$historia_ginecologica->recomendaciones,['placeholder' => 'Recomendaciones y observaciones','class'=>'form-control','rows'=>'6']) !!}
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