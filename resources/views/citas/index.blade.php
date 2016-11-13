@extends('layouts.main')

@section('content-header')
     <h1>
        Citas
        <small>Citas almacenadas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Escritorio</a></li>
        <li><a href="#">Citas</a></li>
      </ol>
@endsection

@section('content')
   
 <div class="row">
        <div class="col-md-3">

          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Crear nuevo Evento</h3>
            </div>
            <div class="box-body">
              <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                <ul class="fc-color-picker" id="color-chooser">
                  <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                </ul>
              </div>
              <!-- /btn-group -->
              <div class="input-group">
                <!--<input id="new-event" type="text" class="form-control" placeholder="Nombre del Evento">-->
                <!-- {!! Form::label('paciente_id','Paciente') !!} -->
                {!! Form::select('pacientes[]',$pacientes,null,['id' => 'new-event', 'class' => 'form-control select2','style' => 'width: 100%','placeholder' => 'Seleccione el Paciente' ]) !!}
                {!! Form::text('fechainicio',null,['class'=>'form-control pull-right', 'id'=>'fechainicio']) !!}
                <!--{!! Form::select('duracion', 
                    [
                       '10' => '10min',
                       '20' => '20min',
                       '30' => '30min', 
                       '40' => '40min',
                       '45' => '45min',
                       '50' => '50min',
                       '60' => '60min' 

                     ], old('duracion'),['id' => 'duracion', 'class' => 'form-control select2','style' => 'width: 100%', 'placeholder' => 'Duración de la Consulta']) !!}-->
                     <!-- <input type="text" class="form-control pull-right" id="reservationtime">-->
                     </div>
                     <div class="checkbox">
                    <label>
                      {!! Form::checkbox('delete',null,false, ['id'=>'delete']) !!}
                      Borrar
                    </label>
                  </div>

                    <!-- <div class="input-group">
                    {!! Form::checkbox('delete',null,false, ['id'=>'delete']) !!}
                    {!! Form::label('borrar','Borrar') !!}
                    </div>-->
                  <!-- /btn-group -->
                  
              
              <div class="input-group-btn">
                  <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Guardar</button>
                </div>
              <!-- /input-group -->
              {!! Form::open(['route' => ['guardarcita'], 'method'=> 'POST', 'id' => 'form-calendario']) !!}
              {!! Form::close() !!}
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

@endsection

@section('javascript')
<!-- fullCalendar 2.2.5 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('plugins/fullcalendar/fullcalendar.min.js') }}"></script>





<!-- Page specific script -->
<script>
  $(function () {
         //Timepicker
    $('#fechainicio').daterangepicker({
      timePicker: true, 
      timePickerIncrement: 5,
      locale: {
       format: 'DD/MM/YYYY h:mm A',
       applyLabel: "Aplicar",
       weekLabel: "S",
       daysOfWeek: [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octobre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1},
       startDate: moment(),
       singleDatePicker: true,
     });

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }

    ini_events($('#external-events div.external-event'));
    
    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },

      //defaultTimedEventDuration: '00:30:00',
            buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
      },
      //CARGA DE EVENTOS POR BD
      events: {url: "api"},

      editable: false,
      droppable: false, // this allows things to be dropped onto the calendar !!!
      drop: function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.end = date;
        copiedEventObject.end = copiedEventObject.end.add(2,'h');
        copiedEventObject.allDay = false;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");
        copiedEventObject.id=$(this).attr("id");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

        // is the "remove after drop" checkbox checked?
        //if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        //}
        var title = copiedEventObject.title;
        var start = copiedEventObject.start.format("YYYY-MM-DD HH:mm");
        var end =   copiedEventObject.end.format("YYYY-MM-DD HH:mm");
        var id_pa = copiedEventObject.id;
        crsfToken = document.getElementsByName("_token")[0].value;
        $.ajax({
          url:'guardarcita',
          data:'title='+ title+'&start='+start+'&id_paciente='+id_pa,
          type: "POST",
          headers:{
            "X-CSRF-TOKEN":crsfToken
          },
          success: function(events){
            console.log("Evento creado");
            $('#calendar').fullcalendar('refetchEvents');
          },
          error: function(json){
            console.log("Error");
          }
        
        });
        
      },
      eventClick: function(calEvent)
      {
        $("#new-event").val(calEvent.id_pa).trigger('change');
        //$("#fechainicio").val(calEvent.start.format('DD/MM/YYYY h:mm A'));
        $('#fechainicio').val('');
        $('#fechainicio').data('daterangepicker').setStartDate(calEvent.start.format('DD/MM/YYYY h:mm A'));
        //alert(calEvent.title);
      }
    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0 || $("#duracion").val() == 0) {
        return;
      }

      //Create events
      /*var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html($("#new-event option:selected").text());\

      //event.attr("id",val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);*/
      crsfToken = document.getElementsByName("_token")[0].value;
      var title= $("#new-event option:selected").text();
      var id_pa= $("#new-event").val();
      var start = $("#fechainicio").val();
      var color= currColor;
      var duracion = 30;
      var borrar = false;
      if ($("input:checked").val() > 0)
      {
        borrar =true;
      }
      $.ajax({
          url:'guardarcita',
          data:'title='+ title+'&start='+start+'&duracion='+duracion+'&id_paciente='+id_pa+'&color='+currColor+'&borrar='+borrar,
          type: "POST",
          headers:{
            "X-CSRF-TOKEN":crsfToken
          },
          success: function(events){
            console.log("Evento creado");
            $('#calendar').fullCalendar('refetchEvents');
          },
          error: function(json){
            console.log("Error");
          }
        
        });  
      //Reset event from text input
      $("#new-event").val('').trigger('change');
      $("#duracion").val('').trigger('change');

    });
  });
</script>
@endsection