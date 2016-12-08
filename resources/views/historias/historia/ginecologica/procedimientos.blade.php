@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Indicaciones</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Indicaciones</li>
    </ol>
@endsection

@section('content')
    
    @include('historias/historia/ginecologica/cabecera')

<!--**************** Procedimientos**********************-->

      <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Procedimientos</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
               <div class="col-md-12">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Observaciones</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($combos['procedimientos'] as $procedimiento)
                                 <tr>
                              
                                    <td>{{ $procedimiento->descripcion }}</td>
                                    <td>{{ $procedimiento->observacion }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ginecologica.procedimientos.destroy',[$paciente->id,$historia_ginecologica->id,$procedimiento->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" data-toggle="modal" href="#myAlert3" class="btn btn-primary btn-sm open-modal">Agregar Procedimiento</button>
                         <a  class="btn btn-default btn-sm" target="_BLANK" href="{{ route('reporte.historia_ginecologica_indicaciones',[$historia_ginecologica->id,'procedimientos']) }}">Descargar</a>

                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="modal fade"  id="myAlert3" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregando Procedimiento</h4>
                </div>
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.procedimientos.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
                <div class="modal-body">
                   
                    
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('descripcion','Descripción') !!}
                            {!! Form::text('descripcion',old('descripcion'),['placeholder' => 'Descripción','class'=>'form-control']) !!}
                        </div>
                    </div>

                  
                     <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('observacion','Observación') !!}
                            {!! Form::text('observacion',old('observacion'),['placeholder' => 'Observación general','class'=>'form-control']) !!}
                        </div>
                    </div>

                    

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Agregar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>



    <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Medicamentos</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
               <div class="col-md-12">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>Nombre</th>
                                    <th>Dosis</th>
                                    <th>Observación</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($combos['medicamentos'] as $medicamento)
                                 <tr>
                              
                                    <td>{{ $medicamento->descripcion }}</td>
                                    <td>{{ $medicamento->dosis }}</td>
                                    <td>{{ $medicamento->observacion }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ginecologica.medicamentos.destroy',[$paciente->id,$historia_ginecologica->id,$medicamento->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" data-toggle="modal" href="#myAlert2" class="btn btn-primary btn-sm open-modal">Agregar Medicamento</button>
                         <a  class="btn btn-default btn-sm" target="_BLANK" href="{{ route('reporte.ginecologia_medicamentos',[$historia_ginecologica->id]) }}">Descargar</a>
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
                    <h4 class="modal-title">Agregando Medicamento</h4>
                </div>
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.medicamentos.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
                <div class="modal-body">
                   
                    
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('descripcion','Descripción') !!}
                            {!! Form::text('descripcion',old('descripcion'),['placeholder' => 'Observación general','class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('dosis','Dosis') !!}
                            {!! Form::text('dosis',old('dosis'),['placeholder' => '','class'=>'form-control']) !!}
                        </div>
                    </div>

                     <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('observacion','Observación') !!}
                            {!! Form::text('observacion',old('observacion'),['placeholder' => 'Observación general','class'=>'form-control']) !!}
                        </div>
                    </div>

                    

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Agregar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Recomendaciones</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
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
                        <a  class="btn btn-default btn-sm" target="_BLANK" href="{{ route('reporte.historia_ginecologica_indicaciones',[$historia_ginecologica->id,'recomendaciones']) }}">Descargar</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

      <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Incapacidad</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.incapacidad.store',$paciente->id,$historia_ginecologica->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}

                <div class="form-group col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('fechainicial','Fecha Inicial') !!}
                        {!! Form::text('fechainicial',date("d/m/Y", strtotime($combos['fechainicial'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker']) !!}
                        
                    </div>

                    <div class="form-group col-md-2">
                        {!! Form::label('fechafinal','Fecha Final') !!}
                        {!! Form::text('fechafinal',date("d/m/Y", strtotime($combos['fechafinal'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group col-md-12">
                        {!! Form::label('observacion','Observación') !!}
                        {!! Form::textarea('observacion',$combos['observacion'],['placeholder' => '','class'=>'form-control','rows' => '2']) !!}
                    </div>
                </div>
           
                   
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        <a  class="btn btn-default btn-sm" target="_BLANK" href="{{ route('reporte.historia_ginecologica_indicaciones',[$historia_ginecologica->id,'incapacidad']) }}">Descargar</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.col -->
        </div>
          <!-- /.row -->
    </div>
    <!-- /.box-body -->

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