
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

            @if(Route::currentRouteName() == 'historias.ginecologica.gestaciones')
                <a href="{{ route('historias.ginecologica.gestaciones',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-primary btn-sm ">Gestaciones</a>
            @else
                <a href="{{ route('historias.ginecologica.gestaciones',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-default btn-sm ">Gestaciones</a>
            @endif
            <!--
            @if(Route::currentRouteName() == 'historias.ginecologica.recomendaciones')
                <a href="{{ route('historias.ginecologica.recomendaciones',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-primary btn-sm ">Recomendaciones</a>
            @else
                <a href="{{ route('historias.ginecologica.recomendaciones',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-default btn-sm ">Recomendaciones</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ginecologica.Incapacidad')
                <a href="{{ route('historias.ginecologica.incapacidad',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-primary btn-sm ">Incapacidad</a>
            @else
                <a href="{{ route('historias.ginecologica.incapacidad',[$paciente->id,$historia_ginecologica->id]) }}" class="btn 
            btn-default btn-sm ">Incapacidad</a>
            @endif-->
            
        </div>
    </div>