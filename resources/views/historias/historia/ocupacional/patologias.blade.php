@extends('layouts.main')

@section('content-header')
	<h1>
        Historias
        <small>Antecedentes Patológicos</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ocupacional',$medico->id]) }}">Historia Ocupacional</a></li>
        <li class="active">Antecedentes Patológicos</li>
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

  	<!--****************Habitos****************-->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Hábitos</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('flash::message')
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.patologias.store_habitos',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('fumador','Fumador') !!}
                        {!! Form::select('fumador',[
                            'No' => 'No',
                            'Si' => 'Si',
                            'Exfumador' => 'Exfumador'
                        ], $datos['fumador'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                  
                    <div class="form-group col-md-3">
                        {!! Form::label('tiempo_fumador_id','Tiempo') !!}
                        {!! Form::select('tiempo_fumador_id',$combos['tiempo_fumadores'], $datos['tiempo_fumador_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
               
                    <div class="form-group col-md-3">
                        {!! Form::label('cantidad_fumador_id','Cantidas/días') !!}
                        {!! Form::select('cantidad_fumador_id',$combos['cantidad_fumadores'], $datos['cantidad_fumador_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('bebedor','Bebedor') !!}
                        {!! Form::select('bebedor',[
                            'No' => 'No',
                            'Si' => 'Si',
                            'Exbebedor' => 'Exbebedor'
                        ], $datos['bebedor'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                 
                    <div class="form-group col-md-3">
                        {!! Form::label('tiempo_licor_id','Tiempo') !!}
                        {!! Form::select('tiempo_licor_id',$combos['tiempo_licores'], $datos['tiempo_licor_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                  
                    <div class="form-group col-md-4">
                        {!! Form::label('tipolicor','Tipo de Licor') !!}
                        {!! Form::text('tipolicor',$datos['tipolicor'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group col-md-3">
                        {!! Form::label('medicamento','Medicamento Psicoactivo') !!}
                        {!! Form::select('medicamento',[
                            'No' => 'No',
                            'Si' => 'Si',
                        ], $datos['medicamento'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>

                    <div class="form-group col-md-3">
                        {!! Form::label('regularidad_medicamento_id','Regularidad') !!}
                        {!! Form::select('regularidad_medicamento_id',$combos['regularidad_medicamentos'], $datos['regularidad_medicamento_id'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('nombremedicamento','Cual?') !!}
                        {!! Form::text('nombremedicamento',$datos['nombremedicamento'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

<!--****************Antecedentes Patológicos****************-->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Patológias</h3>
            <div class="box-tools pull-right">
            	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
       	
          	<div class="row">
            	{!! Form::open(['class' => '','method' => 'POST','route' => 'especialidades.store','role' => 'form']) !!}
              	<div class="box-body">
                	<div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                      		<thead>
                        		<tr>
    								<th>Enfermedad</th>
    								<th class="text-center">Familiar</th>
    								<th class="text-center">Personal</th>
                                    <th>Observación</th>
    								<th class="text-center">Acción</th>
                        		</tr>
                      		</thead>
                      		<tbody>
                                @foreach($datos['enfermedades'] as $enfermedad)
                                 <tr>
                                    <td>{{ $enfermedad->enfermedad->descripcion }}</td>
                                    @if($enfermedad->familiar==1)
                                        <td class="text-center">Si</td>
                                    @else
                                        <td class="text-center">No</td>
                                    @endif 
                                    @if($enfermedad->personal==1)
                                        <td class="text-center">Si</td>
                                    @else
                                        <td class="text-center">No</td>
                                    @endif
                                    <td>{{ $enfermedad->observacion }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ocupacional.patologias.destroy_enfermedad',[$paciente->id,$historia_ocupacional->id,$enfermedad->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                                @endforeach
                      		</tbody>
                    	</table>

                    </div>
                    <div class="box-footer">
                            <button type="button" data-toggle="modal" href="#myAlert3" class="btn btn-primary btn-sm open-modal">Agregar Patología</button>
                        </div>
              	</div>
              	
            	
              	
            	{!! Form::close() !!}
            </div>
            <!-- /.col -->
      	</div>
          <!-- /.row -->
    </div>
    <!-- /.box-body -->
    <div class="modal fade"  id="myAlert3" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregando Patología</h4>
                </div>
                {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.patologias.store_enfermedad',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('enfermedad_id','Enfermedad') !!}
                            {!! Form::select('enfermedad_id',$combos['enfermedades'], old('enfermedad_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group col-md-2">
                            {!! Form::label('familiar','Familiar') !!}
                        </div>
                        <div class="form-group col-md-1">
                            {!! Form::checkbox('familiar', null,false,['class'=>'form-control flat-red']) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-md-2">
                            {!! Form::label('personal','Personal') !!}
                        </div>
                         <div class="form-group col-md-1">
                            {!! Form::checkbox('personal', null,false,['class'=>'form-control flat-red']) !!}
                         </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('observacion','Observación') !!}
                            {!! Form::textarea('observacion',old('observacion'),['placeholder' => '','class'=>'form-control','rows'=>'3']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Agregar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

        <!--****************Inmunizaciones****************-->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Inmunizaciones</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
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
                                    <th>Vacuna</th>
                                    <th class="text-center">Fecha</th>
                                    <th>Dosis</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($datos['inmunizaciones'] as $inmunizacion)
                                 <tr>
                                    <td>{{ $inmunizacion->vacuna }}</td>
                                    <td class="text-center">{{ date("d/m/Y", strtotime($inmunizacion->fecha)) }}</td>
                                    <td>{{ $inmunizacion->dosis }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ocupacional.patologias.destroy_vacuna',[$paciente->id,$historia_ocupacional->id,$inmunizacion->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" data-toggle="modal" href="#myAlert2" class="btn btn-primary btn-sm open-modal">Agregar Vacuna</button>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
          <!-- /.row -->
    </div>
        <!-- /.box-body -->
    <div class="modal fade"  id="myAlert2" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregando Vacuna</h4>
                </div>
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.patologias.store_vacuna',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('vacuna','Vacuna') !!}
                            {!! Form::text('vacuna',old('vacuna'),['placeholder' => 'Nombre de la vacuna','class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <div class="form-group col-md-4">
                            {!! Form::label('fecha','Fecha') !!}
                            {!! Form::text('fecha',old('fecha'),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('dosis','Dosis') !!}
                            {!! Form::text('dosis',old('dosis'),['placeholder' => 'Dosis suministrada','class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Agregar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>

    <!--****************Ginecopstetrica****************-->
@if($paciente->user->genero=='Femenino')    
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Ginecopstétrica</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.patologias.store_ginecobstetrica',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}

                <div class="form-group col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('fum','FUM') !!}
                        {!! Form::text('fum',date("d/m/Y", strtotime($datos['fum'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker']) !!}
                    </div>
                
                    <div class="form-group col-md-2">
                        {!! Form::label('fuc','FUC') !!}
                        {!! Form::text('fuc',date("d/m/Y", strtotime($datos['fuc'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control datepicker']) !!}
                    </div>
                     
                    <div class="form-group col-md-6">
                        {!! Form::label('citologia','Resultado Citología') !!}
                        {!! Form::text('citologia',$datos['citologia'],['placeholder' => '','class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-md-2">
                            {!! Form::label('dismenorrea','Dismenorea') !!}
                            {!! Form::select('dismenorrea',[
                            '0' => 'No',
                            '1' => 'Si'
                            ], $datos['dismenorrea'],['class' => 'form-control','style' => 'width: 100%']) !!}
                    </div>
                    
                </div>

                 <div class="form-group col-md-12">
                    <div class="form-group col-md-2">
                        {!! Form::label('gravidez','Nro. Gravidez') !!}
                        {!! Form::text('gravidez',$datos['gravidez'],['placeholder' => '0','class'=>'form-control']) !!}
                    </div>
                
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
                </div>
                   
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.col -->
        </div>
          <!-- /.row -->
    </div>
    <!-- /.box-body -->
@endif
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
            <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
    </div>
@endsection  
