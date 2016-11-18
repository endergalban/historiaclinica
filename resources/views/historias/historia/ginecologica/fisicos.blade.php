@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Exploración Física</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Exploración Física</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ginecologica/cabecera')

<!--****************Información Ocupacional Actual****************-->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Exploración Física</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('flash::message')
            <div class="row">
                {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.fisicos.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
                <div class="col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('peso','Peso') !!}
                        {!! Form::text('peso',number_format($datos['peso'],2),['placeholder' => '0.00','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-2">
                        {!! Form::label('talla','Talla') !!}
                        {!! Form::text('talla',number_format($datos['talla'],2),['placeholder' => '0.00','class'=>'form-control']) !!}
                    </div>

                </div>
                <div class="col-md-12">

                    <div class="form-group col-md-2">
                        {!! Form::label('pa','PA') !!}
                        {!! Form::text('pa',$datos['pa'],['placeholder' => '###/###','class'=>'form-control']) !!}
                    </div>

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
                        {!! Form::label('aspectogeneral','Aspecto General') !!}
                        {!! Form::textarea('aspectogeneral',$datos['aspectogeneral'],['placeholder' => '','class'=>'form-control','rows'=> '3']) !!}
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