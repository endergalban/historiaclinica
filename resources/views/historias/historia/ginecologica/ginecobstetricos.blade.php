@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Ginecobstétrica</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Ginecobstétrica</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ginecologica/cabecera')

     <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Ginecopstétrica</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
         @include('flash::message')
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.ginecobstetrica.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}

                <div class="form-group col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('fum','FUM') !!}
                        {!! Form::text('fum',date("d/m/Y", strtotime($datos['fum'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker']) !!}
                    </div>

                    <div class="form-group col-md-2">
                            {!! Form::label('seguridad','Seguridad FUM') !!}
                            {!! Form::select('seguridad',[
                            '0' => 'No',
                            '1' => 'Si'
                            ], $datos['seguridad'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                
                    
                </div>

                 <div class="form-group col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('partos','Nro. Partos') !!}
                        {!! Form::text('partos',$datos['partos'],['placeholder' => '0','class'=>'form-control']) !!}
                    </div>
                    <div class="form-group col-md-2">
                        {!! Form::label('abortos','Nro. Abortos') !!}
                        {!! Form::text('abortos',$datos['abortos'],['placeholder' => '0','class'=>'form-control']) !!}
                    </div>
                   <div class="form-group col-md-2">
                        {!! Form::label('cesarias','Nro. Cesarias') !!}
                        {!! Form::text('cesarias',$datos['cesarias'],['placeholder' => '0','class'=>'form-control']) !!}
                    </div>
                     <div class="form-group col-md-2">
                        {!! Form::label('gestaciones','Nro. Gestaciones') !!}
                        {!! Form::text('gestaciones',$datos['gestaciones'],['placeholder' => '0','class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="form-group col-md-12">

                    <div class="form-group col-md-2">
                            {!! Form::label('gestante','Gestante') !!}
                            {!! Form::select('gestante',[
                            '0' => 'No',
                            '1' => 'Si'
                            ], $datos['gestante'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                    
                    <div class="form-group col-md-2">
                        {!! Form::label('fpp','FPP') !!}
                        {!! Form::text('fpp',date("d/m/Y", strtotime($datos['fpp'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker']) !!}
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