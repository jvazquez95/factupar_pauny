$(document).ready(function(){



// var p=1;
var i=1;
   for (i = 1; i <= 7; i ++){
//while(i <=7){


  
        $.ajax({
              url: "index2.php?empleados="+i,  
              dataType: 'json',
              type: "POST",
              ajaxI: i, // Capture the current value of 'i'.
              success: function(response) {
                i = this.ajaxI;
                if (response == 1) {
                  $('.ic_'+i).hide();
                  console.log(response);
                }
                else{
                var jsonData = JSON.parse(JSON.stringify(response));
                //var respuesta = jsonData[0].nombreComercial;
                $.each (jsonData, function (bb) {
                    $('#empleado'+i).html('<strong>'+jsonData[bb].nombreComercial+'</strong>');
                    $('#empleado_s'+i).html(jsonData[bb].nombreComercial);
                    $('#cambiar_empleado').append("<option value='"+i+"'>"+jsonData[bb].nombreComercial+"</option>");
                    $('#empleado_sp'+i).html(jsonData[bb].nombreComercial);


                    

                    // console.log(jsonData[bb].nombreComercial);
                }); 
                }

              },
              error: function() {
                    console.log("No se ha conectado");
                }
        });
        todoscalendario(i);
       //
       //i++;



  }        


// BOTON PREV
$('#boton_prev_calendar').click(function() {
  $('#calendar_1, #calendar_2, #calendar_3, #calendar_4, #calendar_5, #calendar_6,#calendar_7').fullCalendar('prev');
});

// BOTON NEXT
$('#boton_next_calendar').click(function() {
  $('#calendar_1, #calendar_2, #calendar_3, #calendar_4, #calendar_5, #calendar_6,#calendar_7').fullCalendar('next');
});

// BOTON ACTUALIZAR EMPLEADO
$('.boton_actualizar_empleado').click(function() {
$("#calendarModal").modal('hide');
var cliente = $("#modalTitle").val();
var articulo = $("#modaldescripcion").val();
var empleadoactual = $('#empleadoactual').val();
var eventoid = $('#eventID').val();
var empleadoidn = $('#cambiar_empleado').val();
var idarticulo = $('#articuloid').val();
  //alert(eventoid+empleadoidn);
  $.ajax({
  url: 'index2.php',
  data: 'action=actualizar_empleado&id='+eventoid+'&idempleado='+empleadoidn+'&idarticulo='+idarticulo+'&idcliente='+cliente,
  type: "POST",
  success: function(json) {
  //alert(json);
  
var jsond = JSON.stringify(json)
var datos = JSON.parse(jsond);

  //alert("#calendar_"+empleadoactual);
  $("#calendar_"+empleadoactual).fullCalendar('removeEvents',eventoid);


  // $("#calendar_"+empleadoidn).fullCalendar('renderEvent',{ 
  //  id: eventoid, 
  //  title: cliente,
  //  body:articulo, 
  //  start: startTime, end: endTime,},true);




 $("#calendar_"+empleadoidn).fullCalendar('renderEvent',
                   {
                       id: datos[0].id,
                       title: datos[0].title,
                       body: datos[0].body,
                       start: datos[0].start,
                       end: datos[0].end,
                   },


                   true);








  }
  });
});



function todoscalendario(idcalendario){
        var calendar = $('#calendar_'+idcalendario).fullCalendar({
            header:{
                //left: 'prev,next today',
                //center: 'title',
                // right: 'agendaWeek,agendaDay'
            },
            locale: 'ES',
            lang: 'ES',
            timeZone: 'UTC',
            plugins: [ 'dayGrid', 'timeGrid', 'list', 'bootstrap' ],
            themeSystem: 'bootstrap',
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
            defaultView: 'agendaDay',
            editable: true,
            selectable: true,
            allDaySlot: false,
            events: "index2.php?view=1&cant=20&empleado="+idcalendario,

              eventRender:function (event, element, view) {
                          element.find('.fc-title').append("<br/> <strong>Artículo: </strong>" + event.body +"<br> <strong>ID </strong>" + event.id); 
                           element.find('.fc-title').prepend("<strong>Cliente: </strong>"); 
              },

            eventClick:  function(event, jsEvent, view) {
                endtime = $.fullCalendar.moment(event.end).format('h:mm');
                starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');
                var mywhen = starttime + ' - ' + endtime;
                $('#modalTitle').html(event.title);
                $('#modalTitle').val(event.title);

                $('#articuloid').val(event.idarticulo);

                if (event.empleadoactual == null) {
                $('#empleadoactual').val(idcalendario);
                }
                else
                {
                $('#empleadoactual').val(event.empleadoactual);

                }

                if (event.body == null) {
                $('#modaldescripcion').html("No hay información suficiente");
                }
                else{
                $('#modaldescripcion').html(event.body);
                $('#modaldescripcion').val(event.body);
                }


                if (event.servicio == null) {
                $('#modal_paquete').html("No hay información suficiente");
                }
                else{
                $('#modal_paquete').html(event.servicio);
                $('#modal_paquete').val(event.servicio);
                }

                $('#modalWhen').text(mywhen);

                $('#eventID').val(event.id);

                $('#calendarModal').modal();
            },
            
            select: function(start, end, jsEvent,event) {
                endtime = $.fullCalendar.moment(end).format('h:mm');
                starttime = $.fullCalendar.moment(start).format('dddd, MMMM Do YYYY, h:mm');
                var mywhen = starttime + ' - ' + endtime;
                start = moment(start).format();
                end = moment(end).format();
                $('#creareventogral'+idcalendario+' #startTime_'+idcalendario).val(start);
                $('#creareventogral'+idcalendario+' #endTime_'+idcalendario ).val(end);
                $('#creareventogral'+idcalendario+' #when' ).text(mywhen);
                $('#creareventogral'+idcalendario).modal('toggle');
                // }
           },

           eventDrop: function(event, delta){
               $.ajax({
                   url: 'index2.php',
                   data: 'action=update&title='+event.title+'&start='+moment(event.start).format()+'&end='+moment(event.end).format()+'&id='+event.id,
                   type: "POST",
                   success: function(json) {
                   //alert(json);
                   }
               });
           },
           eventResize: function(event) {
               $.ajax({
                   url: 'index2.php',
                   data: 'action=update&title='+event.title+'&start='+moment(event.start).format()+'&end='+moment(event.end).format()+'&id='+event.id,
                   type: "POST",
                   success: function(json) {
                       //alert(json);
                   }
               });
           }
         



        });
        $('#submitButton_'+idcalendario).on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           //e.preventDefault();           
           console.log("EL ID RECOLECTADO ES "+idcalendario+ "EL CUAL SE PASA A LA FUNCION DOSUBMIT");
           $("#creareventogral"+idcalendario).modal('hide');
           var cantidad = $('#cantidad_'+idcalendario).val();
           var startTime = $('#startTime_'+idcalendario).val();
           var endTime = $('#endTime_'+idcalendario).val();
           var numeroemple = $('#submitButton_'+idcalendario).attr("dataid");
           var idcliente = $("#cliente_s"+idcalendario).val();
           var idarticulo = $(".cliente_paquete_"+idcalendario).val();
           var idservicio = $(".cliente_servicio_"+idcalendario).val();
           var sala = $(".cliente_sala_"+idcalendario).val();

           console.log("Es"+idarticulo+" "+idservicio+" "+sala);

           if (idservicio == 0) {
            alert("Debe ingresar un servicio");
           }
           if (idservicio == null) {
            alert("Debe ingresar un servicio");
           }
           // alert(title+startTime+endTime);

           $.ajax({
               url: 'index2.php',
               //data: 'action=add&title='+title+'&start='+startTime+'&end='+endTime+'&idempleado='+numeroemple,
               data:{
                "action" :"add",
                "idcliente" : idcliente,  
                "cantidad" : cantidad,
                "start": startTime,
                "end" : endTime,
                "idempleado": numeroemple,
                "articulo_idarticulo":idarticulo,
                "articulo_idarticulo_servicio" : idservicio,
                "sala": sala
               },
               type: "POST",
               success: function(json) {

                if (json == "error") {
                  alert("Debe ingresar un servicio");
                }

                var jsond = JSON.stringify(json)
                  var datos = JSON.parse(jsond);
                  // console.log("conectado | " + datos[0].nombreComercial);
                  //var nombre = datos[0].nombreComercial;
                   $("#calendar_"+idcalendario).fullCalendar('renderEvent',
                   {
                       id:  datos[0].ultimoid,
                       title: datos[0].cliente,
                       body: datos[0].articulo,
                       start: startTime,
                       end: endTime,
                   },


                   true);

                   //window.location.href = '?action=add&title='+title+'&start='+startTime+'&end='+endTime;

               },
               error: function() {
                    console.log("No se ha conectado");
                }   
           });

             $('#title_'+idcalendario).val('');
       });

        $('#deleteButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           
        $("#calendarModal").modal('hide');
           var eventID = $('#eventID').val();
           $.ajax({
               url: 'index2.php',
               data: 'action=delete&id='+eventID,
               type: "POST",
               success: function(json) {
                   // if(json == 1){
                   //  console.log("funciona");
                   //      $("#calendar_"+idcalendario).fullCalendar('removeEvents',eventID);
                   //     } 
                   // else{
                   //      console.log("No funciona");
                   //      }
                    
                    $("#calendar_"+idcalendario).fullCalendar('removeEvents',eventID);
                   
               }
           });
       });
}

// MODAL GENERAL PARA AGREGAR SIN ESTAR EN CALENDARIO
       $('#submitButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doSubmit();
       });
              function doSubmit(){
           $("#creareventogral").modal('hide');
           var title = $('#cantidad').val();
           var startTime = $('#filter-date').val();
           var endTime = $('#filter-datefinal').val();
           var empleado_id = $("#exampleFormControlSelect1").val();

           endTimeF = moment(endTime).format('dddd, MMMM Do YYYY, H:mm');
           startTimeF = moment(startTime).format('dddd, MMMM Do YYYY, H:mm');
           

           var empleado_idF = empleado_id.substr(3);
           console.log(startTimeF+endTimeF+empleado_idF);
var idcliente = $("#cliente_s"+idcalendario).val();
           var idarticulo = $(".cliente_paquete_"+idcalendario).val();
           var idservicio = $(".cliente_servicio_"+idcalendario).val();
           var sala = $(".cliente_sala_"+idcalendario).val();
           //alert(title+"INICIO:"+startTimeF+"<BR>FINAL:"+endTimeF+"EMPLEADO:"+empleado_id);
           
           $.ajax({
              // data: 'action=add&title='+title+'&start='+startTimeF+'&end='+endTimeF+"&empleadoid="+empleado_id,
              data:{
                "action" :"add",
                "idcliente" : idcliente,  
                "title" : cantidad,
                "start": startTimeF,
                "end" : endTimeF,
                "idempleado": empleado_id,
                "articulo_idarticulo":idarticulo,
                "articulo_idarticulo_servicio" : idservicio,
                "sala": sala
               },

               type: "POST",
               dataType: "json",
               url: 'index2.php',

               success: function(json) {
                console.log("ENVIADO "+title+" | "+startTimeF+" | "+endTimeF+" | "+empleado_id)
                   $("#calendar_"+empleado_idF).fullCalendar('renderEvent',
                   {
                       id: json.id,
                       title: title,
                       start: startTime,
                       end: endTime,
                   },
                   true);
               },
               error: function() {
                    console.log("No se ha conectado");
                }
           });
           
       }
        


      


























//FIN BAR CALENDAR
    });
