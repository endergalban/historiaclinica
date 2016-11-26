@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Examinar Gestaciones</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Examinar Gestaciones</li>
    </ol>
@endsection

@section('content')
    
      <div class="box box-default">
        <div class="box-header with-border">
            <div class="box-header">
                <a href="{{ route('historias.index') }}" class="btn btn-default btn-sm">Ver Historias de pacientes</a>
                <a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}" class="btn btn-default btn-sm ">Ver lista de Historias de {{ $paciente->user->primernombre.' '.$paciente->user->primerapellido }}</a>
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
                 <div class="form-group col-md-12">
                    <h3 class="box-title"><b>Nro. Historia:</b> HG-{{ str_pad($historia_ginecologica->id, 8, "0", STR_PAD_LEFT) }}</h3>
                </div>
            </div>  
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>

            @if(Route::currentRouteName() == 'historias.ginecologica.antecedentes')
                <a href="{{ route('historias.ginecologica.antecedentes',[$paciente->id,$historia_ginecologica->id]) }}" class="btn btn-primary btn-sm ">Antecedentes Generales</a>
            @else
                <a href="{{ route('historias.ginecologica.antecedentes',[$paciente->id,$historia_ginecologica->id]) }}" class="btn btn-default btn-sm ">Antecedentes Generales</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ginecologica.ginecobstetrica')
                <a href="{{ route('historias.ginecologica.ginecobstetrica',[$paciente->id,$historia_ginecologica->id]) }}" class="btn btn-primary btn-sm ">Ginecobstétrica</a>
            @else
                <a href="{{ route('historias.ginecologica.ginecobstetrica',[$paciente->id,$historia_ginecologica->id]) }}" class="btn btn-default btn-sm ">Ginecobstétrica</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ginecologica.edit')
                <a href="{{ route('historias.ginecologica.edit',[$paciente->id,$historia_ginecologica->id]) }}" class="btn btn-primary btn-sm ">Datos de la Consulta</a>
            @else
                <a href="{{ route('historias.ginecologica.edit',[$paciente->id,$historia_ginecologica->id]) }}" class="btn btn-default btn-sm ">Datos de la Consulta</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ginecologica.fisicos')
                <a href="{{ route('historias.ginecologica.fisicos',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-primary btn-sm ">Exploración Física</a>
            @else
                <a href="{{ route('historias.ginecologica.fisicos',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-default btn-sm ">Exploración Física</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ginecologica.diagnosticos')
                <a href="{{ route('historias.ginecologica.diagnosticos',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-primary btn-sm ">Diagnóstico</a>
            @else
                <a href="{{ route('historias.ginecologica.diagnosticos',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-default btn-sm ">Diagnóstico</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ginecologica.procedimientos')
                <a href="{{ route('historias.ginecologica.procedimientos',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-primary btn-sm ">Indicaciones</a>
            @else
                <a href="{{ route('historias.ginecologica.procedimientos',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-default btn-sm ">Indicaciones</a>
            @endif

            
            <a href="{{ route('historias.ginecologica.gestaciones',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-primary btn-sm ">Gestaciones</a>
           
            
        </div>
    </div>

    @include('flash::message')
    @if( ($disabled=='') && (count($combos['ginecologia_exploracion_periodicas'])!=count($combos['ginecologia_exploracion_periodo']) &&($combos['ginecologia_exploracion_inicial']['sacogestacional']!='')))

     <div class="box box-default collapsed-box">
  
        <div class="box-header with-border">
            <h3 class="box-title">Nueva Exploración</h3>
            <div class="box-tools pull-right">
              
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
               
                
            </div>
        </div>

        <!-- /.box-header -->
         <div class="box-body">
         
            <div class="row">
               <div class="col-md-12">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.exploraciones.periodicas.store',$paciente->id,$historia_ginecologica->id, $combos['ginecologia_exploracion_inicial']['id']],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
                 {!! Form::hidden('ginecologia_exploracion_inicial_id', $combos['ginecologia_exploracion_inicial']['id']) !!}
                    <div class="col-md-12">

                     <div class="form-group col-md-4">
                            {!! Form::label('ginecologia_exploracion_periodo_id','Periodo') !!}
                            {!! Form::select('ginecologia_exploracion_periodo_id',$combos['ginecologia_exploracion_periodo'], old('ginecologia_exploracion_periodo_id'),['class' => 'form-control','style' => 'width: 100%']) !!}
                        </div>
                
                    </div>


                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('situacionfetal','Situación Fetal') !!}
                            {!! Form::text('situacionfetal',old('situacionfetal'),['placeholder' => '','class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('dorso','Dorso') !!}
                            {!! Form::text('dorso',old('dorso'),['placeholder' => '','class'=>'form-control']) !!}
                        </div>
                    </div>

                     <div class="col-md-12">
                        <div class="form-group col-md-2">
                            {!! Form::label('dbp','DBM') !!}
                            {!! Form::text('dbp',old('dbp'),['placeholder' => '0.00','class'=>'form-control text-right']) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('lf','LF') !!}
                            {!! Form::text('lf',old('lf'),['placeholder' => '0.00','class'=>'form-control text-right']) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('pabdominal','P-Abdominal') !!}
                            {!! Form::text('pabdominal',old('pabdominal'),['placeholder' => '0.00','class'=>'form-control text-right']) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('actividadmotora','Act. Motora') !!}
                            {!! Form::select('actividadmotora',[
                                '0' => 'No',
                                '1' => 'Si',
                            ], old('actividadmotora'),['class' => 'form-control','style' => 'width: 100%']) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('actividadcardiaca','Act. Cardíaca') !!}
                            {!! Form::select('actividadcardiaca',[
                                '0' => 'No',
                                '1' => 'Si',
                            ], old('actividadcardiaca'),['class' => 'form-control','style' => 'width: 100%']) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('actividadrespiratoria','Act. Respiratoria') !!}
                            {!! Form::select('actividadrespiratoria',[
                                '0' => 'No',
                                '1' => 'Si',
                            ], old('actividadrespiratoria'),['class' => 'form-control','style' => 'width: 100%']) !!}
                        </div>

                    </div>
                    <div class="col-md-12">

                        <div class="form-group col-md-2">
                            {!! Form::label('semanaecografia','Sem. por Ecografía') !!}
                            {!! Form::text('semanaecografia',old('semanaecografia'),['placeholder' => '0','class'=>'form-control text-right']) !!}
                        </div>

                         <div class="form-group col-md-5">
                            {!! Form::label('localizacion','Localización Placentaria') !!}
                            {!! Form::text('localizacion',old('localizacion'),['placeholder' => '','class'=>'form-control']) !!}
                        </div>

                        <div class="form-group col-md-5">
                            {!! Form::label('madurez','Madurez') !!}
                            {!! Form::text('madurez',old('madurez'),['placeholder' => '','class'=>'form-control']) !!}
                        </div>

                    </div>

                     <div class="col-md-12">
                        <h4 >Liquido Amniotico</h4>
                    </div>


                    <div class="col-md-12">

                    
                         <div class="form-group col-md-6">
                            {!! Form::label('liquidovolumen','Volumen') !!}
                            {!! Form::text('liquidovolumen',old('liquidovolumen'),['placeholder' => '','class'=>'form-control']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('liquidoobservaciones','Observaciones') !!}
                            {!! Form::text('liquidoobservaciones',old('liquidoobservaciones'),['placeholder' => '','class'=>'form-control']) !!}
                        </div>

                    </div>


                </div>
              
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn  btn-sm btn-primary">Guardar</button>
                    
                    </div>
                </div>
       
                {!! Form::close() !!}
            </div>
        </div>
       
    </div> 
    @endif
    @foreach($combos['ginecologia_exploracion_periodicas'] as $ginecologia_exploracion_periodica )
         <div class="box box-default collapsed-box">
      
            <div class="box-header with-border">
                <h3 class="box-title">Exploración {{ $ginecologia_exploracion_periodica->ginecologia_exploracion_periodo->descripcion }}</h3>
                <div class="box-tools pull-right">
                  
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   
                    
                </div>
            </div>

            <!-- /.box-header -->
             <div class="box-body">
             
                <div class="row">
                   <div class="col-md-12">
                     
                        <div class="col-md-12">

                         <div class="form-group col-md-4">
                                 {!! Form::label('ginecologia_exploracion_periodo_id','Periodo') !!}
                                 {!! Form::select('ginecologia_exploracion_periodo_id',$combos['ginecologia_exploracion_periodo'], $ginecologia_exploracion_periodica->ginecologia_exploracion_periodo_id,['class' => 'form-control','style' => 'width: 100%','disabled'=>'disabled']) !!}
                            </div>
                            
                            <div class="form-group col-md-6">
                                {!! Form::label('semanaamenorrea','Semana Amenorrea') !!}
                                {!! Form::text('semanaamenorrea',$ginecologia_exploracion_periodica->semanaamenorrea,['placeholder' => '','class'=>'form-control','disabled'=>'disabled']) !!}
                            </div>

                             <div class="form-group col-md-2">
                                {!! Form::label('fechaparto','Fecha P. Parto') !!}
                                {!! Form::text('fechaparto',date("d/m/Y", strtotime($combos['ginecologia_exploracion_inicial']['fechaparto'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control text-center','disabled'=>'disabled']) !!}
                            </div>

                        </div>


                        <div class="col-md-12">
                            <div class="form-group col-md-12">
                                {!! Form::label('situacionfetal','Situación Fetal') !!}
                                {!! Form::text('situacionfetal',$ginecologia_exploracion_periodica->situacionfetal,['placeholder' => '','class'=>'form-control','disabled'=>'disabled']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group col-md-12">
                                {!! Form::label('dorso','Dorso') !!}
                                {!! Form::text('dorso',$ginecologia_exploracion_periodica->dorso,['placeholder' => '','class'=>'form-control','disabled'=>'disabled']) !!}
                            </div>
                        </div>

                         <div class="col-md-12">
                            <div class="form-group col-md-2">
                                {!! Form::label('dbp','DBP') !!}
                                {!! Form::text('dbp',$ginecologia_exploracion_periodica->dbp,['placeholder' => '0.00','class'=>'form-control text-right','disabled'=>'disabled']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('lf','LF') !!}
                                {!! Form::text('lf',$ginecologia_exploracion_periodica->lf,['placeholder' => '0.00','class'=>'form-control text-right','disabled'=>'disabled']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('pabdominal','P-Abdominal') !!}
                                {!! Form::text('pabdominal',$ginecologia_exploracion_periodica->pabdominal,['placeholder' => '0.00','class'=>'form-control text-right','disabled'=>'disabled']) !!}
                            </div>

                             <div class="form-group col-md-2">
                                {!! Form::label('actividadmotora','Act. Motora') !!}
                                {!! Form::select('actividadmotora',[
                                    '0' => 'No',
                                    '1' => 'Si',
                                ],$ginecologia_exploracion_periodica->actividadmotora,['class' => 'form-control','style' => 'width: 100%','disabled'=>'disabled']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('actividadcardiaca','Act. Cardíaca') !!}
                                {!! Form::select('actividadcardiaca',[
                                    '0' => 'No',
                                    '1' => 'Si',
                                ],$ginecologia_exploracion_periodica->actividadcardiaca,['class' => 'form-control','style' => 'width: 100%','disabled'=>'disabled']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('actividadrespiratoria','Act. Respiratoria') !!}
                                {!! Form::select('actividadrespiratoria',[
                                    '0' => 'No',
                                    '1' => 'Si',
                                ],$ginecologia_exploracion_periodica->actividadrespiratoria,['class' => 'form-control','style' => 'width: 100%','disabled'=>'disabled']) !!}
                            </div>


                        </div>
                        <div class="col-md-12">

                            <div class="form-group col-md-2">
                                {!! Form::label('semanaecografia','Sem. por Ecografía') !!}
                                {!! Form::text('semanaecografia',$ginecologia_exploracion_periodica->semanaecografia,['placeholder' => '0','class'=>'form-control text-right','disabled'=>'disabled']) !!}
                            </div>

                             <div class="form-group col-md-5">
                                {!! Form::label('localizacion','Localización Placentaria') !!}
                                {!! Form::text('localizacion',$ginecologia_exploracion_periodica->localizacion,['placeholder' => '','class'=>'form-control','disabled'=>'disabled']) !!}
                            </div>

                            <div class="form-group col-md-5">
                                {!! Form::label('madurez','Madurez') !!}
                                {!! Form::text('madurez',$ginecologia_exploracion_periodica->madurez,['placeholder' => '','class'=>'form-control','disabled'=>'disabled']) !!}
                            </div>

                        </div>

                         <div class="col-md-12">
                            <h4 >Liquido Amniotico</h4>
                        </div>


                        <div class="col-md-12">

                        
                             <div class="form-group col-md-6">
                                {!! Form::label('liquidovolumen','Volumen') !!}
                                {!! Form::text('liquidovolumen',$ginecologia_exploracion_periodica->liquidovolumen,['placeholder' => '','class'=>'form-control','disabled'=>'disabled']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('liquidoobservaciones','Observaciones') !!}
                                {!! Form::text('liquidoobservaciones',$ginecologia_exploracion_periodica->liquidoobservaciones,['placeholder' => '','class'=>'form-control','disabled'=>'disabled']) !!}
                            </div>

                        </div>


                    </div>
                    @if($disabled=='' && $loop->first)
                    <div class="col-md-12">
                        <div class="box-footer">
                         <a data-toggle="modal" data-url="{{ route('historias.ginecologica.destroy_exploraciones',[$paciente->id,$historia_ginecologica->id,$combos['ginecologia_exploracion_inicial']['id'],$ginecologia_exploracion_periodica->id]) }}" class="btn btn-primary btn-sm open-modal" href="#myAlert">Eliminar</a>
                        </div>
                    </div>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
           
        </div> 
        @endforeach


 
        <div class="box box-default collapsed-box">

        <div class="box-header with-border">
            <h3 class="box-title">Exploración Inicial</h3>
            <div class="box-tools pull-right">
             
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                
                
            </div>
        </div>

        <!-- /.box-header -->
         <div class="box-body">
         
            <div class="row">
               <div class="col-md-12">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.exploraciones.store',$paciente->id,$historia_ginecologica->id, $combos['ginecologia_exploracion_inicial']['id']],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
                 {!! Form::hidden('ginecologia_exploracion_inicial_id', $combos['ginecologia_exploracion_inicial']['id']) !!}
                    <div class="col-md-12">
                        <div class="form-group col-md-8">
                            {!! Form::label('semanaamenorrea','Semana Amenorrea') !!}
                            {!! Form::text('semanaamenorrea',$combos['ginecologia_exploracion_inicial']['semanaamenorrea'],['placeholder' => '','class'=>'form-control','disabled'=>'disabled']) !!}
                        </div>

                         <div class="form-group col-md-2">
                            {!! Form::label('fechaparto','Fecha P. Parto') !!}
                            {!! Form::text('fechaparto',date("d/m/Y", strtotime($combos['ginecologia_exploracion_inicial']['fechaparto'])),['placeholder' => 'DD/MM/YYYY','class'=>'form-control text-center','disabled'=>'disabled']) !!}
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-md-2">
                            {!! Form::label('sacogestacional','Saco Gestacional') !!}
                            {!! Form::select('sacogestacional',[
                                '' => '',
                                'Fondo' => 'Fondo',
                                'Centro' => 'Centro',
                                'Istmo' => 'Istmo'
                            ], $combos['ginecologia_exploracion_inicial']['sacogestacional'],['class' => 'form-control','style' => 'width: 100%',$disabled]) !!}
                        </div>
                    
                        <div class="form-group col-md-2">
                            {!! Form::label('formasaco','Forma de Saco') !!}
                            {!! Form::select('formasaco',[
                                '' => '',
                                'Bordes Regulares' => 'Bordes Regulares',
                                'Bordes Irregulares' => 'Bordes Irregulares',
                            ], $combos['ginecologia_exploracion_inicial']['formasaco'],['class' => 'form-control','style' => 'width: 100%',$disabled]) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('visualizacionembrion','Visualización') !!}
                            {!! Form::select('visualizacionembrion',[
                                '0' => 'No',
                                '1' => 'Si',
                            ], $combos['ginecologia_exploracion_inicial']['visualizacionembrion'],['class' => 'form-control','style' => 'width: 100%',$disabled]) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('numeroembriones','Número de Embriones') !!}
                            {!! Form::text('numeroembriones',$combos['ginecologia_exploracion_inicial']['numeroembriones'],['placeholder' => '0','class'=>'form-control',$disabled]) !!}
                        </div>

                    </div>

                    <div class="col-md-12">
                        <h4 >Actividad Embionaria</h4>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-md-2">
                            {!! Form::label('actividadmotora','Actividad Motora') !!}
                            {!! Form::select('actividadmotora',[
                                '0' => 'No',
                                '1' => 'Si',
                            ], $combos['ginecologia_exploracion_inicial']['actividadmotora'],['class' => 'form-control','style' => 'width: 100%',$disabled]) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('actividadcardiaca','Actividad Cardiaca') !!}
                            {!! Form::select('actividadcardiaca',[
                                '0' => 'No',
                                '1' => 'Si',
                            ], $combos['ginecologia_exploracion_inicial']['actividadcardiaca'],['class' => 'form-control','style' => 'width: 100%',$disabled]) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('longitud','Longitud Cefalo-Caudal') !!}
                            {!! Form::text('longitud',$combos['ginecologia_exploracion_inicial']['longitud'],['placeholder' => '0','class'=>'form-control',$disabled]) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h4 >Corion Velloso</h4>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group col-md-2">
                            {!! Form::label('corionanterior','Anterior') !!}
                            {!! Form::select('corionanterior',[
                                '0' => 'No',
                                '1' => 'Si',
                            ], $combos['ginecologia_exploracion_inicial']['corionanterior'],['class' => 'form-control','style' => 'width: 100%',$disabled]) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('corionposterior','Posterior') !!}
                            {!! Form::select('corionposterior',[
                                '0' => 'No',
                                '1' => 'Si',
                            ], $combos['ginecologia_exploracion_inicial']['corionposterior'],['class' => 'form-control','style' => 'width: 100%',$disabled]) !!}
                        </div>

                        <div class="form-group col-md-2">
                            {!! Form::label('corioncervix','Cubre el Cervix') !!}
                            {!! Form::select('corioncervix',[
                                '0' => 'No',
                                '1' => 'Si',
                            ], $combos['ginecologia_exploracion_inicial']['corioncervix'],['class' => 'form-control','style' => 'width: 100%',$disabled ]) !!}
                        </div>
                    </div>


                     <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('ecocardiagrama','EG Por Ecografía') !!}
                            {!! Form::textarea('ecocardiagrama',$combos['ginecologia_exploracion_inicial']['ecocardiagrama'],['placeholder' => '','class'=>'form-control','rows'=>'3',$disabled]) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('observaciones','Observaciones') !!}
                            {!! Form::textarea('observaciones',$combos['ginecologia_exploracion_inicial']['observaciones'],['placeholder' => '','class'=>'form-control','rows'=>'3',$disabled]) !!}
                        </div>
                    </div>

                </div>
                @if($disabled=='' && count($combos['ginecologia_exploracion_periodicas'])==0 )
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn  btn-sm btn-primary">Guardar</button>
                       
                    </div>
                </div>
                @endif
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