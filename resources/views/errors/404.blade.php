@extends('layouts.main')

@section('content-header')
     <h1>
        Error 404
        <small>Página no encontrada</small>
      </h1>
      
@endsection

@section('content')
   <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Página no encontrada.</h3>

          <p>
            Estas solicitando información de un recurso que no existe o fue movido a otro lugar.
            Mientras tanto, puedes <a href="{{ route('home') }}">retornar al escritorio</a> o realizar una busqueda.
          </p>
         @if(Auth::user()->hasAnyRole('administrador'))
            {!! Form::open(['method' => 'GET','route' => ['users.index'],'role' => 'form','class' => 'search-form']) !!}
          @elseif(Auth::user()->hasAnyRole(['asistente','medico']))
            {!! Form::open(['method' => 'GET','route' => ['pacientes.index'],'role' => 'form','class' => 'search-form']) !!}
          @endif
          
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Buscar...">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          {{Form::close()}}
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
@endsection