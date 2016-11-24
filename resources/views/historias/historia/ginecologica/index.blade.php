@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Historia ginecológica del paciente</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li class="active">Historia Ginecológica del paciente</li>
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
            <h3 class="box-title">Historias Ginecológicas</h3>
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
                        <th>Nro. Historia</th>
                        <th>Fecha</th>
                        
                        <th class="text-center">Acción</th>
                        <th class="text-center">Descargas</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach( $historia_ginecologicas as $historia )
                    <tr>
                        <td>HG-{{ str_pad($historia->id, 8, "0", STR_PAD_LEFT) }}</td>
                        <td>{{ date("d/m/Y", strtotime($historia->created_at))  }}</td>
                       
                                             
                        <td class="text-center">
                            @if($historia->activa==1 and  $acciones==true)
                                <a href="{{ route('historias.ginecologica.edit',[$paciente->id,$historia->id]) }}" ><span class="label label-warning">Editar</span></a>
                                <a href="{{ route('historias.ginecologica.documentos',[$paciente->id,$historia->id]) }}" ><span class="label bg-purple">Documentos</span></a>
                                <a data-toggle="modal" data-url="{{ route('historias.destroy_ginecologica',[$paciente->id,$medico->id , $historia->id ]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                            @else
                                <a href="#" ><span class="label label-default">Editar</span></a>
                                <a href="#" ><span class="label label-default">Documentos</span></a>
                                <a href="#" ><span class="label label-default">Eliminar</span></a>
                            @endif
                        </td>
                         <td class="text-right"> 
                           
                              <a href="{{ route('reporte.historia_ginecologica',[$historia->id]) }}" target="_BLANK"><span class="label label-primary" >Historia</span></a>
                        </td> 
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if($acciones==true)
                <a class="btn btn-default btn-sm pull-right open-modal" data-toggle="modal" data-url="{{ route('historias.ginecologica.create',[$paciente->id,$medico->id]) }}" href="#myAlert" >Crear Nueva Historia Ginecológica</a>
            @endif
            
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