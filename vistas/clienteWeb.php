<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

requierePermisoVista(basename(__FILE__, '.php'));
if ($_SESSION['contabilidad']==1)
{
?>

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro de Clientes</title>
    <link rel="manifest" href="/manifest.json">
<!-- Popper.js, antes de Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvgzfSWlExKv-FxZVULP42xz5_zHoFVA8&callback=initMap&libraries=&v=weekly" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Registro de clientes</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <form id="formularioRegistro" method="post" enctype="multipart/form-data">
                    <span class="badge badge-success"> <?php echo $_SESSION["login"] ?></span>

            <div class="form-group">
              
                <label for="nombreCompleto">Nombre Completo:</label>
                <input type="text" class="form-control" id="nombreCompleto" required>
                <input type="hidden" class="form-control" id="usuario" value = " <?php echo $_SESSION["login"] ?> ">
            </div>
            <div class="form-group">
                <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="fechaNacimiento" required>
            </div>
            <div class="form-group">
                <label for="tipoDocumento">Tipo de Documento:</label>
                <select class="form-control" id="tipoDocumento">
                    <option value="1">RUC</option>
                    <option value="2">CÉDULA</option>
                    <option value="3">Documento Extranjero</option>
                </select>
            </div>
            <div class="form-group">
                <label for="numeroDocumento">Nro de Documento:</label>
                <input type="text" class="form-control" id="numeroDocumento" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" class="form-control" id="telefono" required>
            </div>



            <div class="form-group">
                <label for="imagen">Subir Imagen:</label>
                <input type="file" class="form-control-file" id="imagen" accept="image/*" capture="camera">
                <input type="hidden" class="form-control" id="imagenBase64" required>

            </div>

            <div class="form-group">
                <label>Días de la Semana:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="domingo" value="1">
                    <label class="form-check-label" for="domingo">Domingo</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="lunes" value="1">
                    <label class="form-check-label" for="lunes">Lunes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="martes" value="1">
                    <label class="form-check-label" for="martes">Martes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="miercoles" value="1">
                    <label class="form-check-label" for="miercoles">Miércoles</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="jueves" value="1">
                    <label class="form-check-label" for="jueves">Jueves</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="viernes" value="1">
                    <label class="form-check-label" for="viernes">Viernes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="sabado" value="1">
                    <label class="form-check-label" for="sabado">Sábado</label>
                </div>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" id="direccion" required>
            </div>
            <div class="form-group">
                <label for="ciudad">Ciudad:</label>
                <!-- <select class="form-control selectpicker" id="ciudad" data-live-search="true"> -->
                <select   title="Selecciona Ciudad" class="selectpicker selector_persona form-control"  name="ciudad" id="ciudad"  data-live-search="true" required></select>

                </select>
            </div>

            <div id="map"></div>
            <input type="hidden" id="latitud">
            <input type="hidden" id="longitud">

            <br>
            <br>
            <button type="submit" id="botonGuardar" class="btn btn-primary btn-lg d-block mx-auto">Guardar</button>

        </form>

        <div id="loading" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999;">
            <img src="cargando.gif" alt="Cargando..." style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        </div>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->



      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>


$(document).ready(function(){
  $('select.selector_persona').selectpicker();
    $(".bs-searchbox input").on('input', function() {

   var esto = this; 
    $.ajax({
    type: "POST",
    url: "../ajax/persona.php?op=selectCiudadLimit",
    data:{keyword:$(this).val(), tipoPersona: 1},
    success: function(data){
       $("select.selector_persona ").html(data);
      $("select.selector_persona").selectpicker("refresh");
    },
    error: function(data){
        console.log("NO se pudo enviar");
    }
    });
  });
    $("select.selector_persona").change(function(){
        var idPersona = $(this).children("option:selected").val();
 
    });
});


            if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
            .then(function(registration) {
                console.log('Service Worker registrado con éxito:', registration);
            })
            .catch(function(error) {
                console.log('Error al registrar el Service Worker:', error);
            });
            }




            $(document).ready(function() {
                var fecha = new Date();
                var dia = ("0" + fecha.getDate()).slice(-2);
                var mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
                var fechaFormateada = fecha.getFullYear() + "-" + mes + "-" + dia;

                $("#fechaNacimiento").val(fechaFormateada);
            });



            $(document).ready(function() {
                $('#ciudad').selectpicker({
                    liveSearch: true
                });
            });




    let map;
let marker;

function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: userLocation
            });

            marker = new google.maps.Marker({
                position: userLocation,
                map: map,
                draggable: true
            });

            // Actualizar latitud y longitud en los campos ocultos y obtener el nombre de la ciudad
            updateLatLng(userLocation.lat, userLocation.lng);
            getCityName(userLocation.lat, userLocation.lng);

            google.maps.event.addListener(marker, 'dragend', function() {
                const newPosition = marker.getPosition();
                updateLatLng(newPosition.lat(), newPosition.lng());
                getCityName(newPosition.lat(), newPosition.lng());
            });
        }, function() {
            handleLocationError(true, map.getCenter());
        });
    } else {
        // El navegador no soporta Geolocalización
        handleLocationError(false, map.getCenter());
    }
}

function updateLatLng(lat, lng) {
    document.getElementById('latitud').value = lat;
    document.getElementById('longitud').value = lng;
}

// Variable global para almacenar el nombre de la última ciudad seleccionada
let lastCityName = "";

function getCityName(lat, lng) {
    const geocoder = new google.maps.Geocoder();
    const latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                let cityFound = false;
                results.some(result => {
                    return result.address_components.some(component => {
                        if (component.types.includes('locality')) {
                            const cityName = component.long_name.toUpperCase();
                            console.log(cityName); // Imprime el nombre de la ciudad en mayúsculas
                            
                            // Actualiza el label y realiza la llamada AJAX solo si la ciudad ha cambiado
                            if (cityName !== lastCityName) {
                                updateCityLabel(cityName); // Actualiza el label con el nombre de la ciudad
                                
                                $.ajax({
                                    type: "POST",
                                    url: "../ajax/persona.php?op=selectCiudadLimit",
                                    data: {keyword: cityName, tipoPersona: 1},
                                    success: function(data) {
                                    const $selectorPersona = $("select.selector_persona");
                                    // Actualiza el select con el nuevo contenido HTML
                                    $selectorPersona.html(data);
                                    // Refresca el selectpicker para aplicar los cambios
                                    $selectorPersona.selectpicker('refresh');

                                    // $("#ciudad").val(g_idCliente);
			                        // $("#ciudad").selectpicker("refresh");

                                },

                                    error: function() {
                                        console.log("No se pudo enviar");
                                    }
                                });
                                
                                lastCityName = cityName; // Actualiza la última ciudad seleccionada
                            }
                            cityFound = true;
                            return true;
                        }
                        return false;
                    });
                });
                if (!cityFound) console.log('Ciudad no encontrada');
            } else {
                console.log('No se encontraron resultados');
            }
        } else {
            console.log('Geocoder falló debido a: ' + status);
        }
    });
}

function updateCityLabel(cityName) {
    let cityLabel = document.getElementById("cityLabel");
    const selectElement = document.getElementById("ciudad");

    if (!cityLabel) {
        cityLabel = document.createElement("label");
        cityLabel.setAttribute("id", "cityLabel");
        cityLabel.setAttribute("for", "ciudad");
    }
    cityLabel.textContent = `Ciudad: ${cityName}`;

    // Asegura insertar el label correctamente en el DOM, justo antes del select.
    selectElement.parentNode.insertBefore(cityLabel, selectElement);
}

        $(document).ready(function(){

            $("#formularioRegistro").on("submit", function(e){
                e.preventDefault();

                var datosCliente = {
                    nombreCompleto: $("#nombreCompleto").val(),
                    usuario: $("#usuario").val(),
                    fechaNacimiento: $("#fechaNacimiento").val(),
                    tipoDocumento: $("#tipoDocumento").val(),
                    numeroDocumento: $("#numeroDocumento").val(),
                    email: $("#email").val(),
                    telefono: $("#telefono").val(),
                    direccion: $("#direccion").val(),
                    ciudad: $("#ciudad").val(),
                    imagen: $("#imagenBase64").val(), // Asegúrate de manejar la carga de archivos en tu servidor
                    diasSemana: {
                        domingo: $("#domingo").is(":checked") ? 1 : 0,
                        lunes: $("#lunes").is(":checked") ? 1 : 0,
                        martes: $("#martes").is(":checked") ? 1 : 0,
                        miercoles: $("#miercoles").is(":checked") ? 1 : 0,
                        jueves: $("#jueves").is(":checked") ? 1 : 0,
                        viernes: $("#viernes").is(":checked") ? 1 : 0,
                        sabado: $("#sabado").is(":checked") ? 1 : 0
                    },
                    latitud: $("#latitud").val(),
                    longitud: $("#longitud").val()
                };

                $("#loading").show();
                $.ajax({
                    url: 'https://factupar.com.py/cerrocora/api/public/usuario/insertar_web',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(datosCliente),
                    success: function(response) {
                        Swal.fire('Éxito', 'Cliente registrado con éxito!', 'success');
                        $("#formularioRegistro")[0].reset();
                        $("#loading").hide();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Ocurrió un error al registrar el cliente.', 'error');
                        $("#loading").hide();
                    }
                });
            });
        });


        function convertirImagenABase64(input, callback) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    callback(e.target.result); // La imagen en Base64
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imagen").change(function() {
            convertirImagenABase64(this, function(base64Img) {
                // Aquí tienes la imagen en Base64, puedes asignarla a una variable
                // o hacer algo con ella (por ejemplo, asignarla a un campo oculto del formulario).
                $('#imagenBase64').val(base64Img);
            });
        });

    </script>

  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>

<?php 
}
ob_end_flush();
?>


