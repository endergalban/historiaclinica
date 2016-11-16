@extends('layouts.main')

@section('content-header')
     <h1>
        Historias
        <small>Antecedentes Ocupacionales Lesiones</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ocupacional',$medico->id]) }}">Historia Ocupacional</a></li>
        <li><a href="{{ route('historias.ocupacional.antecedentes',[$paciente->id,$historia_ocupacional->id,$antecedente_ocupacional->id]) }}">Antecedentes Ocupacionales</a></li>
        <li class="active">Lesiones</li>
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
                <div class="form-group col-md-12">
                    <h3 class="box-title"><b>Nro. Historia:</b> HO-{{ str_pad($historia_ocupacional->id, 8, "0", STR_PAD_LEFT) }}</h3>
                </div>
                <div class="form-group col-md-12">
                    <h3 class="box-title"><b>Empresa:</b> {{ $antecedente_ocupacional->empresa }}</h3>
                </div>
            </div>  
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>

            <a href="{{ route('historias.ocupacional.edit',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Datos del Paciente</a>

            <a href="{{ route('historias.ocupacional.consentimientos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Consentimiento</a>

            <a href="{{ route('historias.ocupacional.actual',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Ocupación Actual</a>

            <a href="{{ route('historias.ocupacional.antecedentes',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Antecedentes</a>

            <a href="{{ route('historias.ocupacional.patologias',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Patologías</a>

            <a href="{{ route('historias.ocupacional.fisicos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Examen Físico</a>

            <a href="{{ route('historias.ocupacional.alturas',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Altura</a>

            <a href="{{ route('historias.ocupacional.examenes',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Exámenes</a>

            <a href="{{ route('historias.ocupacional.diagnosticos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn 
            btn-default btn-sm ">Diagnóstico</a>

            <a href="{{ route('historias.ocupacional.recomendaciones',[$paciente->id,$historia_ocupacional->id]) }}" class="btn 
            btn-default btn-sm ">Recomendaciones</a>
            
        </div>
    </div>

<!--****************Información Ocupacional ****************-->
  
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Lesiones</h3>
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
                                    <th>Lesión</th>
                                    <th>Secuelas</th>
                                    <th>Arl</th>
                                    <th class="text-center">Acción</th>
                                <tr>
                            </thead>
                            <tbody>
                                @foreach($combos['traumatologicos'] as $traumatologico)
                                <tr>
                                   
                                    @if( $traumatologico->lesion->descripcion == 'Otros' && $traumatologico->otro !='' )
                                        <td>{{ $traumatologico->otro }}</td>
                                    @else
                                        <td>{{ $traumatologico->lesion->descripcion }}</td>
                                    @endif
                                    <td>{{ $traumatologico->secuela }}</td>
                                    <td>{{ $traumatologico->arl }}</td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-url="{{ route('historias.ocupacional.antecedentes.destroy_lesion',[$paciente->id,$historia_ocupacional->id,$antecedente_ocupacional->id,$traumatologico->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="button" data-toggle="modal" href="#myAlert2" class="btn btn-primary btn-sm open-modal">Agregar Lesión</button>
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
                    <h4 class="modal-title">Agregando Lesión</h4>
                </div>
                {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ocupacional.antecedentes.lesiones.store',$paciente->id,$historia_ocupacional->id,$antecedente_ocupacional->id],'role' => 'form']) !!}
                {!! Form::hidden('historia_ocupacional_id', $historia_ocupacional->id) !!}
                {!! Form::hidden('antecedente_ocupacional_id', $antecedente_ocupacional->id) !!}
             
                <div class="modal-body" >
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('lesion_id','Tipo de Lesión') !!}
                            {!! Form::select('lesion_id',$combos['lesiones'], old('lesion_id'),['class' => 'form-control lesion_id select2','style' => 'width: 100%']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('otro','Otra Lesión') !!}
                            {!! Form::text('otro',old('otro'),['placeholder' => '','class'=>'form-control','disabled'=>'form-disabled']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('secuela','Secuela') !!}
                            {!! Form::text('secuela',old('secuela'),['placeholder' => '','class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            {!! Form::label('arl','Arl') !!}
                            {!! Form::text('arl',old('arl'),['placeholder' => '','class'=>'form-control']) !!}
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


@section('javascript')
<script >

$(document).on("change", ".lesion_id", function () {
    texto=$("#lesion_id option:selected").html();
    if(texto.slice(-5,-1) == 'Otro'){

        $('#otro').prop('disabled', false);
        $('#otro').focus();
    }else{
        $('#otro').val('');
        $('#otro').prop('disabled', true);
    }
});

</script>  
@endsection  