@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Incapacidad</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Incapacidad</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ginecologica/cabecera')

     <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Incapacidad</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
         @include('flash::message')
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.incapacidad.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}

                <div class="form-group col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('fechainicial','Fecha Inicial') !!}
                        {!! Form::text('fechainicial',date("d/m/Y", strtotime($datos['fechainicial'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker']) !!}
                        
                    </div>

                    <div class="form-group col-md-2">
                        {!! Form::label('fechafinal','Fecha Final') !!}
                        {!! Form::text('fechafinal',date("d/m/Y", strtotime($datos['fechafinal'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('observacion','Observación') !!}
                        {!! Form::textarea('observacion',$datos['observacion'],['placeholder' => '','class'=>'form-control','rows' => '2']) !!}
                    </div>
                </div>
           
                   
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.col -->
        </div>
          <!-- /.row -->
    </div>
    <!-- /.box-body -->
@endsection
