
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
            </div>  
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>

            @if(Route::currentRouteName() == 'historias.ocupacional.edit')
                <a href="{{ route('historias.ocupacional.edit',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-primary btn-sm ">Datos del Paciente</a>
            @else
                <a href="{{ route('historias.ocupacional.edit',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Datos del Paciente</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ocupacional.consentimientos')
                <a href="{{ route('historias.ocupacional.consentimientos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-primary btn-sm ">Consentimiento</a>
            @else
                <a href="{{ route('historias.ocupacional.consentimientos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Consentimiento</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ocupacional.actual')
                <a href="{{ route('historias.ocupacional.actual',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-primary btn-sm ">Ocupación Actual</a>
            @else
                <a href="{{ route('historias.ocupacional.actual',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Ocupación Actual</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ocupacional.antecedentes')
                <a href="{{ route('historias.ocupacional.antecedentes',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-primary btn-sm ">Antecedentes</a>
            @else
                <a href="{{ route('historias.ocupacional.antecedentes',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Antecedentes</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ocupacional.patologias')
                <a href="{{ route('historias.ocupacional.patologias',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-primary btn-sm ">Patologías</a>
            @else
                <a href="{{ route('historias.ocupacional.patologias',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Patologías</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ocupacional.fisicos')
                <a href="{{ route('historias.ocupacional.fisicos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-primary btn-sm ">Examen Físico</a>
            @else
                <a href="{{ route('historias.ocupacional.fisicos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Examen Físico</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ocupacional.alturas')
                <a href="{{ route('historias.ocupacional.alturas',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-primary btn-sm ">Altura</a>
            @else
                <a href="{{ route('historias.ocupacional.alturas',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Altura</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ocupacional.examenes')
                <a href="{{ route('historias.ocupacional.examenes',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-primary btn-sm ">Exámenes</a>
            @else
                <a href="{{ route('historias.ocupacional.examenes',[$paciente->id,$historia_ocupacional->id]) }}" class="btn btn-default btn-sm ">Exámenes</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ocupacional.diagnosticos')
                <a href="{{ route('historias.ocupacional.diagnosticos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn 
            btn-primary btn-sm ">Diagnóstico</a>
            @else
                <a href="{{ route('historias.ocupacional.diagnosticos',[$paciente->id,$historia_ocupacional->id]) }}" class="btn 
            btn-default btn-sm ">Diagnóstico</a>
            @endif

            @if(Route::currentRouteName() == 'historias.ocupacional.recomendaciones')
                <a href="{{ route('historias.ocupacional.recomendaciones',[$paciente->id,$historia_ocupacional->id]) }}" class="btn 
            btn-primary btn-sm ">Recomendaciones</a>
            @else
                <a href="{{ route('historias.ocupacional.recomendaciones',[$paciente->id,$historia_ocupacional->id]) }}" class="btn 
            btn-default btn-sm ">Recomendaciones</a>
            @endif
                

            

            
          

           

            

            
            
        </div>
    </div>