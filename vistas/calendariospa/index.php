
<!doctype html>
<html lang="en"><head>
    <title>jQuery Fullcalendar Integration with Bootstrap, PHP & MySQL | PHPLift.net</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <style type="text/css">
    
      img {border-width: 0}
      * {font-family:'Lucida Grande', sans-serif;}
    </style>
  </head>
  <body  >
  

    <style type="text/css">

  
    </style>

  


<br /><br />
<hr />  



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>



<!-- FULLCALENDAR -->
<link href="css/fullcalendar.css" rel="stylesheet" />
<link href="css/fullcalendar.print.css" rel="stylesheet" media="print" />
<script src="js/moment.min.js"></script>
<script src="js/fullcalendar.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0//core/main.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/bootstrap/main.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0//bootstrap/main.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>

<!-- add calander in this div -->

<div class="">


  <!-- <input type="text" id="search-box" placeholder="Country Name" />
  <select id="suggesstion-box"></select>

  <input type="text" id="search-box" placeholder="Country Name" />
   -->
    <div class="row event_bo566">
        <div class="col-md-12">
            <h3 class="text-center">Calendario Eventos  </h3>
            <h4 id="titulocalendario"></h4>
        </div>
        <div class="d-flex align-items-center col-md-12">
            <button id="boton_prev_calendar" type="button" class="d-flex justify-content-center celetes btn btn-primary">Anterior</button>
            <button id="boton_calendar" data-toggle="modal" data-target="#creareventogral" type="button" class="d-flex justify-content-center celetes btn btn-primary">Agregar evento</button>
            <button id="boton_next_calendar" type="button" class="d-flex justify-content-center celetes btn btn-primary">Siguiente</button>

        </div>
    </div>
    <div class="row d-flex">
<div class="d-flex justify-content-center">...</div>

    </div>
</div>
<hr>
<div class="container-fluid">
  <div class="row">
  <div class="col colend_indv ic_1"><div id="empleado1"></div> <div class="showcalendar" id="calendar_1" data-n="1"></div></div>
  <div class="col colend_indv ic_2"><div id="empleado2"></div><div class="showcalendar" id="calendar_2" data-n="2"></div></div>
  <div class="col colend_indv ic_3"><div id="empleado3"></div><div class="showcalendar" id="calendar_3" data-n="3"></div></div>
  <div class="col colend_indv ic_4"><div id="empleado4"></div><div class="showcalendar" id="calendar_4" data-n="4"></div></div>
   <div class="col colend_indv ic_5"><div id="empleado5"></div><div class="showcalendar" id="calendar_5" data-n="5"></div></div>
  <div class="col colend_indv ic_6"><div id="empleado6"></div><div class="showcalendar" id="calendar_6" data-n="6"></div></div>
<div class="col colend_indv ic_7"><div id="empleado7"></div>
                <div class="showcalendar" id="calendar_7" data-n="7"></div>
            </div>
  </div>


    
</div>


<!-- ELEMENTO DE PRUEBAS -->
<div class="container content">
    <div class="row">
        <div id="calendar"></div>
    </div>
</div>
<!-- SE PUEDE BORRAR -->




<div class="modal fade" id="creareventogral" tabindex="-1" role="dialog" aria-labelledby="creareventogral1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creareventograllabel">Agregar evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
            <input type="hidden" id="startTime"/>
            <input type="hidden" id="endTime"/>
        <div class="form-group">
            <label class="form-label" for="when">Fecha inicial:</label>
<input class="form-control" type="text" id="filter-date">
            <div class="controls controls-row" id="when" style="margin-top:5px;">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="when">Fecha final:</label>
<input class="form-control" type="text" id="filter-datefinal">
            
        </div>
 <div class="form-group">
            <label for="exampleFormControlSelect1">Empleado</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option id="empleado_sp1" value="em_1"><div > </div></option>
              <option id="empleado_sp2" value="em_2"><div > </div></option>
              <option id="empleado_sp3" value="em_3"><div > </div></option>
              <option id="empleado_sp4" value="em_4"><div > </div></option>
              <option id="empleado_sp5" value="em_5"><div > </div></option>
              <option id="empleado_sp6" value="em_6"><div > </div></option>
              <option id="empleado_sp7" value="em_7"><div > </div></option>
            </select>
          </div>


<div class="form-group">
            <label for="cliente">Cliente</label>
            <select  onchange="cargarPS(8);"  title="Selecciona un cliente" class="selectpicker form-control cliente_s8" id="cliente_s8" data-live-search="true"></select>
          </div>

          <div class="form-group">
            <label for="cliente_paquete">Paquete</label>
            <select onchange="cargarS(8);" class="form-control cliente_paquete_8"  id="cliente_paquete">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente_servicio">Servicio</label>
            <select title="Seleciona un Servicio" class="form-control cliente_servicio_8" id="cliente_servicio">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente">Sala</label>
            <select class="form-control cliente_sala_8" id="cliente_sala" required>
              <option id="sala_2" value="1">Sala 1</option>
              <option id="sala_2" value="2">Sala 2</option>
              <option id="sala_2" value="3">Sala 3</option>
              <option id="sala_2" value="4">Sala 4</option>
              <option id="sala_2" value="5">Sala 5</option>
              <option id="sala_2" value="6">Sala 6</option>
            </select>
          </div>
          <div class="form-group">
                <label class="form-label" for="inputPatient">Cantidad:</label>
                <div class="field desc">
                    <input class="form-control" id="cantidad" name="cantidad"  type="number" value="1">
                </div>
            </div>

      </div>

      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary submitButton" id="submitButton" dataid="1">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="creareventogral1" tabindex="-1" role="dialog" aria-labelledby="creareventogral1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creareventograllabel">Agregar evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
            <input type="hidden" id="startTime_1"/>
            <input type="hidden" id="endTime_1"/>
        <div class="form-group">
            <label class="form-label" for="when">Fecha:</label>
            <div class="controls controls-row" id="when" style="margin-top:5px;">
            </div>
        </div>
 <div class="form-group">
            <label for="exampleFormControlSelect1">Empleado</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option id="empleado_s1" value="em_1"><div > </div></option>
            </select>
          </div>
<div class="form-group">
            <label for="cliente">Cliente</label>
            <select  onchange="cargarPS(1);"  title="Selecciona un cliente" class="selectpicker form-control cliente_s1" id="cliente_s1" data-live-search="true"></select>
          </div>

          <div class="form-group">
            <label for="cliente_paquete">Paquete</label>
            <select onchange="cargarS(1);" class="form-control cliente_paquete_1"  id="cliente_paquete">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente_servicio">Servicio</label>
            <select title="Seleciona un Servicio" class="form-control cliente_servicio_1" id="cliente_servicio">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente">Sala</label>
            <select class="form-control cliente_sala_1" id="cliente_sala">
              <option id="sala_2" value="1">Sala 1</option>
              <option id="sala_2" value="2">Sala 2</option>
              <option id="sala_2" value="3">Sala 3</option>
              <option id="sala_2" value="4">Sala 4</option>
              <option id="sala_2" value="5">Sala 5</option>
              <option id="sala_2" value="6">Sala 6</option>
            </select>
          </div>
          <div class="form-group">
                <label class="form-label" for="inputPatient">Cantidad:</label>
                <div class="field desc">
                    <input class="form-control" id="cantidad_1" name="cantidad"  type="number" value="1">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary submitButton" id="submitButton_1" dataid="1">Guardar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="creareventogral2" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creareventograllabel">Agregar evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           
            <input type="hidden" id="startTime_2"/>
            <input type="hidden" id="endTime_2"/>
        <div class="form-group">
            <label class="form-label" for="when">Fecha:</label>
            <div class="controls controls-row" id="when" style="margin-top:5px;">
            </div>
        </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Empleado</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option id="empleado_s2" value="em_2"><div > </div></option>
            </select>
          </div>
          <div class="form-group">
            <label for="cliente">Cliente</label>
            <select  onchange="cargarPS(2);"  title="Selecciona un cliente" class="selectpicker form-control cliente_s2" id="cliente_s2" data-live-search="true"></select>
          </div>

          <div class="form-group">
            <label for="cliente_paquete">Paquete</label>
            <select onchange="cargarS(2);" class="form-control cliente_paquete_2"  id="cliente_paquete">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente_servicio">Servicio</label>
            <select title="Seleciona un Servicio" class="form-control cliente_servicio_2" id="cliente_servicio">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente">Sala</label>
            <select class="form-control cliente_sala_2" id="cliente_sala">
              <option id="sala_2" value="1">Sala 1</option>
              <option id="sala_2" value="2">Sala 2</option>
              <option id="sala_2" value="3">Sala 3</option>
              <option id="sala_2" value="4">Sala 4</option>
              <option id="sala_2" value="5">Sala 5</option>
              <option id="sala_2" value="6">Sala 6</option>
            </select>
          </div>
          <div class="form-group">
                <label class="form-label" for="inputPatient">Cantidad:</label>
                <div class="field desc">
                    <input class="form-control" id="cantidad_2" name="cantidad"  type="number" value="1">
                </div>
            </div>


      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary submitButton" id="submitButton_2" dataid="2">Guardar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="creareventogral3">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creareventograllabel">Agregar evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
            <input type="hidden" id="startTime_3"/>
            <input type="hidden" id="endTime_3"/>
        <div class="form-group">
            <label class="form-label" for="when">Fecha:</label>
            <div class="controls controls-row" id="when" style="margin-top:5px;">
            </div>
        </div>
 <div class="form-group">
            <label for="exampleFormControlSelect1">Empleado</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option id="empleado_s3" value="em_3"><div > </div></option>
            </select>
          </div>
<div class="form-group">
            <label for="cliente">Cliente</label>
            <select  onchange="cargarPS(3);"  title="Selecciona un cliente" class="selectpicker form-control cliente_s3" id="cliente_s3" data-live-search="true"></select>
          </div>

          <div class="form-group">
            <label for="cliente_paquete">Paquete</label>
            <select onchange="cargarS(3);" class="form-control cliente_paquete_3"  id="cliente_paquete">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente_servicio">Servicio</label>
            <select title="Seleciona un Servicio" class="form-control cliente_servicio_3" id="cliente_servicio">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente">Sala</label>
            <select class="form-control cliente_sala_3" id="cliente_sala">
              <option id="sala_2" value="1">Sala 1</option>
              <option id="sala_2" value="2">Sala 2</option>
              <option id="sala_2" value="3">Sala 3</option>
              <option id="sala_2" value="4">Sala 4</option>
              <option id="sala_2" value="5">Sala 5</option>
              <option id="sala_2" value="6">Sala 6</option>
            </select>
          </div>
          <div class="form-group">
                <label class="form-label" for="inputPatient">Cantidad:</label>
                <div class="field desc">
                    <input class="form-control" id="cantidad_3" name="cantidad"  type="number" value="1">
                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary submitButton" id="submitButton_3" dataid="3">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="creareventogral4">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creareventograllabel">Agregar evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           
            <input type="hidden" id="startTime_4"/>
            <input type="hidden" id="endTime_4"/>
        <div class="form-group">
            <label class="form-label" for="when">Fecha:</label>
            <div class="controls controls-row" id="when" style="margin-top:5px;">
            </div>
        </div>
 <div class="form-group">
            <label for="exampleFormControlSelect1">Empleado</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option id="empleado_s4" value="em_4"><div > </div></option>
            </select>
          </div>
<div class="form-group">
            <label for="cliente">Cliente</label>
            <select  onchange="cargarPS(4);"  title="Selecciona un cliente" class="selectpicker form-control cliente_s4" id="cliente_s4" data-live-search="true"></select>
          </div>

          <div class="form-group">
            <label for="cliente_paquete">Paquete</label>
            <select onchange="cargarS(4);" class="form-control cliente_paquete_4"  id="cliente_paquete">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente_servicio">Servicio</label>
            <select title="Seleciona un Servicio" class="form-control cliente_servicio_4" id="cliente_servicio">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente">Sala</label>
            <select class="form-control cliente_sala_4" id="cliente_sala">
              <option id="sala_2" value="1">Sala 1</option>
              <option id="sala_2" value="2">Sala 2</option>
              <option id="sala_2" value="3">Sala 3</option>
              <option id="sala_2" value="4">Sala 4</option>
              <option id="sala_2" value="5">Sala 5</option>
              <option id="sala_2" value="6">Sala 6</option>
            </select>
          </div>
           <div class="form-group">
                <label class="form-label" for="inputPatient">Cantidad:</label>
                <div class="field desc">
                    <input class="form-control" id="cantidad_4" name="cantidad"  type="number" value="1">
                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary submitButton" id="submitButton_4" dataid="4">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="creareventogral5">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creareventograllabel">Agregar evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
            <input type="hidden" id="startTime_5"/>
            <input type="hidden" id="endTime_5"/>
        <div class="form-group">
            <label class="form-label" for="when">Fecha:</label>
            <div class="controls controls-row" id="when" style="margin-top:5px;">
            </div>
        </div>
 <div class="form-group">
            <label for="exampleFormControlSelect1">Empleado</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option id="empleado_s5" value="em_5"><div > </div></option>
            </select>
          </div>
<div class="form-group">
            <label for="cliente">Cliente</label>
            <select  onchange="cargarPS(5);"  title="Selecciona un cliente" class="selectpicker form-control cliente_s5" id="cliente_s5" data-live-search="true"></select>
          </div>

          <div class="form-group">
            <label for="cliente_paquete">Paquete</label>
            <select onchange="cargarS(5);" class="form-control cliente_paquete_5"  id="cliente_paquete">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente_servicio">Servicio</label>
            <select title="Seleciona un Servicio" class="form-control cliente_servicio_5" id="cliente_servicio">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente">Sala</label>
            <select class="form-control cliente_sala_5" id="cliente_sala">
              <option id="sala_2" value="1">Sala 1</option>
              <option id="sala_2" value="2">Sala 2</option>
              <option id="sala_2" value="3">Sala 3</option>
              <option id="sala_2" value="4">Sala 4</option>
              <option id="sala_2" value="5">Sala 5</option>
              <option id="sala_2" value="6">Sala 6</option>
            </select>
          </div>
          <div class="form-group">
                <label class="form-label" for="inputPatient">Cantidad:</label>
                <div class="field desc">
                    <input class="form-control" id="cantidad_5" name="cantidad"  type="number" value="1">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary submitButton" id="submitButton_5" dataid="5">Guardar</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="creareventogral6">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creareventograllabel">Agregar evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
            <input type="hidden" id="startTime_6"/>
            <input type="hidden" id="endTime_6"/>
        <div class="form-group">
            <label class="form-label" for="when">Fecha:</label>
            <div class="controls controls-row" id="when" style="margin-top:5px;">
            </div>
        </div>
 <div class="form-group">
            <label for="exampleFormControlSelect1">Empleado</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option id="empleado_s6" value="em_6"><div > </div></option>
            </select>
          </div>
<div class="form-group">
            <label for="cliente">Cliente</label>
            <select  onchange="cargarPS(6);"  title="Selecciona un cliente" class="selectpicker form-control cliente_s6" id="cliente_s6" data-live-search="true"></select>
          </div>

          <div class="form-group">
            <label for="cliente_paquete">Paquete</label>
            <select onchange="cargarS(6);" class="form-control cliente_paquete_6"  id="cliente_paquete">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente_servicio">Servicio</label>
            <select title="Seleciona un Servicio" class="form-control cliente_servicio_6" id="cliente_servicio">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente">Sala</label>
            <select class="form-control cliente_sala_6" id="cliente_sala">
              <option id="sala_2" value="1">Sala 1</option>
              <option id="sala_2" value="2">Sala 2</option>
              <option id="sala_2" value="3">Sala 3</option>
              <option id="sala_2" value="4">Sala 4</option>
              <option id="sala_2" value="5">Sala 5</option>
              <option id="sala_2" value="6">Sala 6</option>
            </select>
          </div>
          <div class="form-group">
                <label class="form-label" for="inputPatient">Cantidad:</label>
                <div class="field desc">
                    <input class="form-control" id="cantidad_6" name="cantidad"  type="number" value="1">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary submitButton" id="submitButton_6" dataid="6">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="creareventogral7">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creareventograllabel">Agregar evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
            <input type="hidden" id="startTime_7"/>
            <input type="hidden" id="endTime_7"/>
        <div class="form-group">
            <label class="form-label" for="when">Fecha:</label>
            <div class="controls controls-row" id="when" style="margin-top:5px;">
            </div>
        </div>
 <div class="form-group">
            <label for="exampleFormControlSelect1">Empleado</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option id="empleado_s7" value="em_7"><div > </div></option>
            </select>
          </div>
<div class="form-group">
            <label for="cliente">Cliente</label>
            <select  onchange="cargarPS('7');"  title="Selecciona un cliente" class="selectpicker form-control cliente_s7" id="cliente_s7" data-live-search="true"></select>
          </div>

          <div class="form-group">
            <label for="cliente_paquete">Paquete</label>
            <select onchange="cargarS('7');" class="form-control cliente_paquete_7"  id="cliente_paquete">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente_servicio">Servicio</label>
            <select title="Seleciona un Servicio" class="form-control cliente_servicio_7" id="cliente_servicio">
            </select>
          </div>
          <div class="form-group">
            <label for="cliente">Sala</label>
            <select class="form-control cliente_sala_7" id="cliente_sala">
              <option id="sala_2" value="1">Sala 1</option>
              <option id="sala_2" value="2">Sala 2</option>
              <option id="sala_2" value="3">Sala 3</option>
              <option id="sala_2" value="4">Sala 4</option>
              <option id="sala_2" value="5">Sala 5</option>
              <option id="sala_2" value="6">Sala 6</option>
            </select>
          </div>
          <div class="form-group">
                <label class="form-label" for="inputPatient">Cantidad:</label>
                <div class="field desc">
                    <input class="form-control" id="cantidad_7" name="cantidad"  type="number" value="1">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary submitButton" id="submitButton_7" dataid="7">Guardar</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal CREAR ENVENTO GENERAL -->




<!-- Modal -->
















<div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creareventograllabel">Detalles evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <strong>Cliente:</strong>
        <h4 id="modalTitle" class="modal-title"> </h4>
        <strong>Paquete:</strong>
        <div id="modaldescripcion" style="margin-top:5px;"></div>

        <strong>Servicio:</strong>
        <div id="modal_paquete" style="margin-top:5px;">No seleccionado</div>
        <strong>Fecha:</strong>
        <div id="modalWhen" style="margin-top:5px;"></div>




        <strong>Editar empleado</strong>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Empleado</label>
            <select class="form-control" id="cambiar_empleado">
              <option>Selecciona empleado</option>
            </select>
          </div>


        <input type="hidden" id="eventID"/>

        <input type="hidden"   id="empleadoactual">


        <input type="hidden"   id="articuloid">

        <input type="hidden"   id="idcliente">

      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn boton_actualizar_empleado" >Actualizar</button>
      </div>
    </div>
  </div>
</div>
<!--Modal-->


<div style='margin-left: auto;margin-right: auto;text-align: center;'>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/locales/es.js'></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
</html><script type="text/javascript" src="js/ajax_script/script.js"></script>


        <script src="js/jquery.datetimepicker.full.js"></script>

        <script type="text/javascript">


// AJAX call for autocomplete 
$(document).ready(function(){
  $('.selectpicker').selectpicker();


  $(".bs-searchbox input").keyup(function(){

   var esto = this; 
    $.ajax({
    type: "POST",
    url: "ajax_Cliente.php",
    data:'keyword='+$(this).val(),
    beforeSend: function(){
      // $("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
    },

    success: function(data){
      $(".selectpicker").show();
      $(".selectpicker").html(data);
      $("#search-box").css("background","#FFF");
      $(".selectpicker").selectpicker("refresh");

    }
    });
  });
});
//To select country name
function selectCountry(val) {
$("#search-box").val(val);
$(".selectpicker").hide();
}






            /*jslint browser:true*/
            /*global jQuery, document*/
            jQuery.datetimepicker.setLocale('mx');
            jQuery(document).ready(function () {
                'use strict';

                jQuery('#filter-date, #filter-datefinal').datetimepicker({
 i18n:{
  de:{
   months:[
    'Enero','Febrero','Marzo','Abril',
    'Mayo','Junio','Julio','Agosto',
    'Septiembre','Octubre','Noviembre','Diciembre',
   ],
   dayOfWeek:[
    "Do", "Lu", "Ma", "Mi", 
    "Jue", "Vi", "Sab",
   ]
  }
 }
                });
            });
        </script>



  </body>
</html>
