	window.addEventListener("keypress", function(event){
    if (event.keyCode == 13){
        event.preventDefault();
    }
	}, false);


 function enter2tab(e) {
       if (e.keyCode == 13) {
           cb = parseInt($(this).attr('tabindex'));
    
           if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
               $(':input[tabindex=\'' + (cb + 1) + '\']').focus();
               $(':input[tabindex=\'' + (cb + 1) + '\']').select();
               e.preventDefault();
    
               return false;
           }
       }
   }





// function crud(ventana){
//   window.open("../vistas/"+ ventana +".php", "Diseño Web", "width=600, height=600");
// }


function crudAnular(ventana, id) {
    var ventanawo = window.open("../vistas/"+ ventana +".php", "PYVENTAS"+ventana, "width=600, height=600");
    var interval = setInterval(function(){
        if(ventanawo.closed !== false) {

          window.clearInterval(interval)

      if (ventana == "cargo") {
      $.post("../ajax/cargo.php?op=selectCargo", function(r){
                  $("#Cargo_idCargo_l").html(r);
                  $('#Cargo_idCargo_l').selectpicker('refresh');
      });
      }else  if (ventana == "centroDeCostos") {
      $.post("../ajax/centroDeCostos.php?op=selectCentroDeCostos", function(r){
                  $("#CentroCosto_idCentroCosto").html(r);
                  $('#CentroCosto_idCentroCosto').selectpicker('refresh');
      });
      }
      else  if (ventana == "grupoArticulo") {
      $.post("../ajax/articulo.php?op=selectGrupo", function(r){
                  $("#GrupoArticulo_idGrupoArticulo").html(r);
                  $('#GrupoArticulo_idGrupoArticulo').selectpicker('refresh');

      });
      }




        } 


    },1000)
    
  
}




function crud(ventana) {
    var ventanawo = window.open("../vistas/"+ ventana +".php", "PYVENTAS"+ventana, "width=600, height=600");
    var interval = setInterval(function(){
        if(ventanawo.closed !== false) {

          window.clearInterval(interval)

      if (ventana == "cargo") {
      $.post("../ajax/cargo.php?op=selectCargo", function(r){
                  $("#Cargo_idCargo_l").html(r);
                  $('#Cargo_idCargo_l').selectpicker('refresh');
      });
      }else  if (ventana == "centroDeCostos") {
      $.post("../ajax/centroDeCostos.php?op=selectCentroDeCostos", function(r){
                  $("#CentroCosto_idCentroCosto").html(r);
                  $('#CentroCosto_idCentroCosto').selectpicker('refresh');
      });
      }else  if (ventana == "grupoArticulo") {
      $.post("../ajax/articulo.php?op=selectGrupo", function(r){
                  $("#GrupoArticulo_idGrupoArticulo").html(r);
                  $('#GrupoArticulo_idGrupoArticulo').selectpicker('refresh');

      });
      }


      else if(ventana == "persona"){
      $.post("../ajax/persona.php?op=selectProveedor", function(r){
                  $("#Persona_idPersona").html(r);
                  $('#Persona_idPersona').selectpicker('refresh');

      });
      }


      else if(ventana == "barrio"){
      $.post("../ajax/barrio.php?op=selectBarrio", function(r){
                  $("#Barrio_idBarrio_l").html(r);
                  $('#Barrio_idBarrio_l').selectpicker('refresh');

      });
      }


      else if(ventana == "tipoDireccionTelefono"){
      $.post("../ajax/tipoDireccionTelefono.php?op=selectTipoDireccionTelefono", function(r){
                  $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_l").html(r);
                  $('#TipoDireccion_Telefono_idTipoDireccion_Telefono_l').selectpicker('refresh');

                  $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l").html(r);
                  $('#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l').selectpicker('refresh');


      });
      }


      else if(ventana == "grupoPersona"){
      //Cargamos los items al select categoria
      $.post("../ajax/grupoPersona.php?op=selectGrupoPersona", function(r){
                  $("#GrupoPersona_idGrupoPersona_l").html(r);
                  $('#GrupoPersona_idGrupoPersona_l').selectpicker('refresh');

      });
      }


      else if(ventana == "ciudad"){
      $.post("../ajax/ciudad.php?op=selectCiudad", function(r){
                  $("#Ciudad_idCiudad_l").html(r);
                  $('#Ciudad_idCiudad_l').selectpicker('refresh');

      });
      }




      else if(ventana == "marca"){
      $.post("../ajax/marca.php?op=selectMarca", function(r){
                  $("#Marca_idMarca").html(r);
                  $('#Marca_idMarca').selectpicker('refresh');

      });
      }
      else if(ventana == "categoria"){
      $.post("../ajax/articulo.php?op=selectCategoria", function(r){
                  $("#Categoria_idCategoria").html(r);
                  $('#Categoria_idCategoria').selectpicker('refresh');
                  $("#Categoria_idCategoriaD").html(r);
                  $('#Categoria_idCategoriaD').selectpicker('refresh');

      });
      }


      else if(ventana == "departamento"){
        $.post("../ajax/departamento.php?op=selectDepartamento", function(r){
                    $("#Departamento_idDepartamento").html(r);
                    $('#Departamento_idDepartamento').selectpicker('refresh');

        });
      }

      else if(ventana == "cargo"){
        $.post("../ajax/cargo.php?op=selectCargo", function(r){
                    $("#Cargo_idCargo").html(r);
                    $('#Cargo_idCargo').selectpicker('refresh');

        });
      }

      else if(ventana == "estadoCivil"){
        $.post("../ajax/estadoCivil.php?op=selectEstadoCivil", function(r){
                    $("#EstadoCivil_idEstadoCivil").html(r);
                    $('#EstadoCivil_idEstadoCivil').selectpicker('refresh');

        });
      }

      else if(ventana == "profesion"){
        $.post("../ajax/profesion.php?op=selectProfesion", function(r){
                    $("#Profesion_idProfesion").html(r);
                    $('#Profesion_idProfesion').selectpicker('refresh');

        });
      }

      else if(ventana == "clase"){
          $.post("../ajax/clase.php?op=selectClase", function(r){
                      $("#Clase_idClase").html(r);
                      $('#Clase_idClase').selectpicker('refresh');

          });
      }

      else if(ventana == "tipoSalario"){
          $.post("../ajax/tipoSalario.php?op=selectTipoSalario", function(r){
                      $("#TipoSalario_idTipoSalario").html(r);
                      $('#TipoSalario_idTipoSalario').selectpicker('refresh');

          });
      }

      else if(ventana == "tipoContrato"){
        $.post("../ajax/tipoContrato.php?op=selectTipoContrato", function(r){
                    $("#TipoContrato_idTipoContrato").html(r);
                    $('#TipoContrato_idTipoContrato').selectpicker('refresh');

        });
      }


      else if(ventana == "medioCobro"){
        $.post("../ajax/medioCobro.php?op=selectMedioCobro", function(r){
                    $("#MedioCobro_idMedioCobro").html(r);
                    $('#MedioCobro_idMedioCobro').selectpicker('refresh');

        });
      }

      else if(ventana == "unidad"){
      $.post("../ajax/articulo.php?op=selectUnidad", function(r){
                  $("#Unidad_idUnidad_l").html(r);
                  $('#Unidad_idUnidad_l').selectpicker('refresh');

        });
      }



        } 


    },1000)
    
  
}




//Separador de miles al momento de escribir
function separadorMilesOnKey(event,input){
    if(event.which >= 37 && event.which <= 40){
      event.preventDefault();
    }
    var $this = $(input);
    var num = $this.val().replace(/[^\d]/g,'').split("").reverse().join("");
    var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1.").split("").reverse().join(""), ".");
    return $this.val(num2);
}

function RemoveRougeChar(convertString, separa){
  if(convertString.substring(0,1) == separa){
    return convertString.substring(1, convertString.length)            
    }
  return convertString;
}

function separadorMiles(x) {
  if(x){
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }else{
    return 0;
  }
}