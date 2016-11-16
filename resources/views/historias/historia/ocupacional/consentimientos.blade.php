@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Consentimiento del Paciente</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ocupacional',$medico->id]) }}">Historia Ocupacional</a></li>
        <li class="active">Consentimiento del Paciente</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ocupacional/cabecera')

<!--**************** RECOMENDACIONES**********************-->

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Consentimiento del Paciente</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('flash::message')
            <div class="row">
                 {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.consentimientos.store',$paciente->id,$historia_ocupacional->id],'role' => 'form']) !!}
                 {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                <div class="col-md-12">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo de Examenes</th>
                                    <th class="text-center">Verificar</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach($combos['Tipo_consentimientos'] as $Tipo_consentimiento)
                                 <tr>
                                    <td >{{ $Tipo_consentimiento['descripcion'] }}</td>
                                    @if($Tipo_consentimiento['descripcion']!='Otros')
                                        <td class="text-center">
                                          {!! Form::checkbox($Tipo_consentimiento['id'], $Tipo_consentimiento['id'],$Tipo_consentimiento['valor'],['class'=>'form-control flat-red']) !!}       
                                        </td>
                                    @else
                                        <td class="text-center">
                                         {!! Form::checkbox($Tipo_consentimiento['id'], $Tipo_consentimiento['id'],$Tipo_consentimiento['valor'],['class'=>'form-control flat-red','id' =>'otrocheck']) !!} 
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($combos['otro']=="")
                <div class="form-group col-md-12" style="display:none" id="otrodiv">
                @else
                <div class="form-group col-md-12" style="" id="otrodiv">
                @endif

                        <div class="form-group col-md-12">
                            {!! Form::label('otro','Otro') !!}
                            {!! Form::textarea('otro',$combos['otro'],['placeholder' => 'Describa el tipo de examen','class'=>'form-control','rows'=>'3']) !!}
                        </div>
                    </div>
                </div>
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm open-modal">Guardar</button>
                    <a href="{{ route('reporte.consentimiento_informado',[$historia_ocupacional->id]) }}" target="_BLANK"><span class="btn btn-default btn-sm" >Descargar Consentimiento Informado</span></a>
                </div>
               
                {!! Form::close() !!}
            </div>
        </div>
    </div>
 @endsection

 @section('javascript')
<script >
  $('#otrocheck').on('ifChecked', function(event){
        $('#otrodiv').show();
        $('#otro').focus();
   });

  $('#otrocheck').on('ifUnchecked', function(event){
        
        $('#otro').val('');
        $('#otrodiv').hide();
   });


</script> 
@endsection