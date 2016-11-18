@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Documentos anexos a la historia</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Documentos</li>
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

          
            
        </div>
    </div>


    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Documentos</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('flash::message')
            <div class="row">
               <div class="col-md-12">
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th  class="text-center">Tamaño</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($files as $file)

                                <tr>
                                    <td>{{ $file['nombre'] }}</td>
                                    <td class="text-center">{{ $file['size'] }}</td>
                                    <td class="text-center"><i class="fa {{ $file['tipo'] }}" ></i></td>
                                    <td class="text-center">
                                    <a  href="{{ route('descargar',Crypt::encrypt($file['ruta'])) }}"><span class="label label-info">Descargar</span></a>
                                    <a data-toggle="modal" data-url="{{ route('historias.ginecologica.documentos.destroy',[$paciente->id,$historia_ginecologica->id,Crypt::encrypt($file['ruta']) ]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                         
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {!! Form::open(['class' => '','method' => 'POST','route' => ['historias.ginecologica.documentos.store',$paciente->id,$historia_ginecologica->id],'role' => 'form','files' => true]) !!}
                {!! Form::hidden('historia_ginecologica_id', $historia_ginecologica->id) !!}
                <div class="col-md-12">
                    <div class="form-group col-md-3">   
                         {!! Form::file('documento', null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit"  class="btn btn-primary btn-sm">Agregar Documento</button>
                    </div>
                </div>
                {{ Form::close() }}
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