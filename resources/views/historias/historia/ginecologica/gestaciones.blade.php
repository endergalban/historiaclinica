@extends('layouts.main')

@section('content-header')
    <h1>
        Historias
        <small>Gestaciones</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="{{ route('historias.index') }}">Historias</a></li>
        <li><a href="{{ route('historias.historia',[$paciente->id,'ginecologica',$medico->id]) }}">Historia Ginecológica</a></li>
        <li class="active">Gestaciones</li>
    </ol>
@endsection

@section('content')
    @include('historias/historia/ginecologica/cabecera')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Gestaciones</h3>
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
                                    
                                    <th class="text-center">Nro</th>
                                    <th class="text-center">Fecha Posible de Parto</th>
                                    <th>Observaciones</th>
                                        <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($combos['ginecologia_exploracion_iniciales'] as $exploracion_inicial)

                                 <tr>
                              
                                    <td class="text-center">{{ $loop->remaining+1 }}</td>
                                    <td class="text-center">{{ date("d/m/Y", strtotime($exploracion_inicial->fechaparto)) }}</td>
                                    <td>{{ $exploracion_inicial->observaciones }}</td>
                                    <td class="text-center">
                                        <a  href="{{ route('historias.ginecologica.exploraciones',[$paciente->id,$historia_ginecologica->id,$exploracion_inicial->id]) }}"><span class="label label-warning">Exploración</span></a>

                                        @if($exploracion_inicial->activa==1 && $historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->gestante==1)
                                            <a data-toggle="modal" data-url="{{ route('historias.ginecologica.destroy_gestaciones',[$paciente->id,$historia_ginecologica->id,$exploracion_inicial->id]) }}" class="open-modal" href="#myAlert"><span class="label label-danger">Eliminar</span></a>
                                        @else
                                            <a  href="#"><span class="label label-default">Eliminar</span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->gestante==1)
                <div class="col-md-12">
                    <div class="box-footer">
                     <a data-toggle="modal" data-url="{{ route('historias.ginecologica.gestaciones.store',[$paciente->id,$historia_ginecologica->id]) }}" class="btn btn-primary btn-sm open-modal" href="#myAlert">Agregar Nueva Gestación</a>

                       
                    </div>
                </div>
                @endif
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
