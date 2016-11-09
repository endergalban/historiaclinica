@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Historia ocupacional del paciente</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li class="active">Historia ocupacional del paciente</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
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

             <a href="{{ route('historias.index') }}" class="pull-right"><button type="submit" class="btn btn-default btn-sm">Ver lista de Historias</button></a>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Historias Ocupacionales</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        
        <div class="box-body table-responsive">
        @include('flash::message')
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Fecha</th>
                        <th>Empresa</th>
                        <th>Tipo de Examen</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $historias as $historia )
                    <tr>
                        <td>{{ $historia->created_at }}</td>
                        <td>{{ $historia->empresa }}</td>
                        <td>{{ $historia->tipo_examen->descripcion }}</td>
                        
                        <td class="text-center">
                            <a href="#"><span class="label label-primary">Descargar</span></a>
                            <a href="{{ route('historias.ocupacional.edit',[$paciente->id,$historia->id]) }}" ><span class="label label-warning">Editar</span></a>
                            <a data-toggle="modal" data-url="{{ route('historias.destroy_ocupacional',[$paciente->id,$medico->id , $historia->id ]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a class="btn btn-default btn-sm pull-right open-modal" data-toggle="modal" data-url="{{ route('historias.ocupacional.create',[$paciente->id,$medico_paciente->id]) }}" href="#myAlert" >Crear Nueva Historia Ocupacional</a>
             Total: {{ $historias->count() }}
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