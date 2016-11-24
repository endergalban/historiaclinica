@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Antecedentes Generales</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Antecedentes Generales</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ginecologica/cabecera')

<!--****************Información Ocupacional Actual****************-->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Antecedentes Generales</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('flash::message')
            <div class="row">
                {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.antecedentes.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
           
                 <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('alergias','Alergias a Medicamentos') !!}
                        {!! Form::text('alergias',$datos['alergias'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>

                 <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('ingresos','Ingresos Previos y Cirugias') !!}
                        {!! Form::text('ingresos',$datos['ingresos'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>

                 <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('traumatismos','Traumas y Accidentes') !!}
                        {!! Form::text('traumatismos',$datos['traumatismos'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>

                 <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('tratamientos','Tratamientos Habituales') !!}
                        {!! Form::text('tratamientos',$datos['tratamientos'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>

                <div class="col-md-12">
                    <div class="form-group col-md-2">
                      {!! Form::label('hta','HTA') !!}
                      {!! Form::select('hta', 
                      [
                            false => 'No',
                            true  => 'Si',

                       ], $datos['hta'],['class' => 'form-control select2','style' => 'width: 100%']) !!}
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group col-md-2">
                      {!! Form::label('displidemia','Displidemia') !!}
                      {!! Form::select('displidemia', 
                      [
                           false => 'No',
                            true  => 'Si',

                       ], $datos['displidemia'],['class' => 'form-control select2','style' => 'width: 100%']) !!}
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group col-md-2">
                      {!! Form::label('dm','DM') !!}
                      {!! Form::select('dm', 
                      [
                            false => 'No',
                            true  => 'Si',

                       ], $datos['dm'],['class' => 'form-control select2','style' => 'width: 100%']) !!}
                    </div>
                    <!-- /.form-group -->
                </div>


                <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('otros','Otros') !!}
                        {!! Form::text('otros',$datos['otros'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>

                 <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('habitos','Habitos Tóxicos') !!}
                        {!! Form::text('habitos',$datos['habitos'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>

                 <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('situacion','Situación Basal (Crónicos)') !!}
                        {!! Form::text('situacion',$datos['situacion'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>

                 <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('familiares','Antecedentes familiares de interes') !!}
                        {!! Form::text('familiares',$datos['familiares'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                     <!-- /.form-group -->
                </div>



                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection