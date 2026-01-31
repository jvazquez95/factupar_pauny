<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Fastmer Paraguay</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
    </style>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>

<?php 


//error_reporting(0);
include('conexionBD.php');
$codigo =  $_GET['codigo'];
$sth = $dbh->query("SELECT * from usuario where Codigo = '$codigo'");
$sth->execute();
if ($sth->rowCount() == 0) {
echo "<div class='container'>

	<img src='https://robsa.com.py/fastmer/assets/cambiarPassword.jpg' class='img-fluid'  alt='Recuperar Password'>


	<div class='row'>
	<div class='col-sm-12'>
	<div class='alert alert-danger' role='alert'>
		El link ya se ha utilizado o ha caducado. Recupere nuevamente su contraseña o contacte con servicio tecnico.
	</div>
	</div>
	</div>
";
return;
}

?>


<div class="container">
<img src='https://robsa.com.py/fastmer/assets/cambiarPassword.jpg' class='img-fluid' alt='Recuperar Password'>
<div class="row">
<div class="col-sm-12">
<p class="text-center">Utilice el siguiente formulario para cambiar su contraseña . La contraseña no puede ser el mismo que su nombre de usuario.</p>
<form method="post" id="passwordForm" action="update_pass.php">
<input type="hidden" class="input-lg form-control" name="codigo" id="codigo" placeholder="Nueva Contraseña" autocomplete="off" value="<?php echo $_GET['codigo']; ?>">


<input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Nueva contraseña" autocomplete="off">
<br>
<input type="submit" class="col-xs-12 btn btn-primary btn-block" data-loading-text="Cambiar contraseña..." value="Cambiar Contraseña">
</form>
</div><!--/col-sm-6-->
</div><!--/row-->
</div>



<script type="text/javascript">
	

</script>
<script type="text/javascript">
$("input[type=password]").keyup(function(){
    var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	
	if($("#password1").val().length >= 8){
		$("#8char").removeClass("glyphicon-remove");
		$("#8char").addClass("glyphicon-ok");
		$("#8char").css("color","#00A41E");
	}else{
		$("#8char").removeClass("glyphicon-ok");
		$("#8char").addClass("glyphicon-remove");
		$("#8char").css("color","#FF0004");
	}
	
	if(ucase.test($("#password1").val())){
		$("#ucase").removeClass("glyphicon-remove");
		$("#ucase").addClass("glyphicon-ok");
		$("#ucase").css("color","#00A41E");
	}else{
		$("#ucase").removeClass("glyphicon-ok");
		$("#ucase").addClass("glyphicon-remove");
		$("#ucase").css("color","#FF0004");
	}
	
	if(lcase.test($("#password1").val())){
		$("#lcase").removeClass("glyphicon-remove");
		$("#lcase").addClass("glyphicon-ok");
		$("#lcase").css("color","#00A41E");
	}else{
		$("#lcase").removeClass("glyphicon-ok");
		$("#lcase").addClass("glyphicon-remove");
		$("#lcase").css("color","#FF0004");
	}
	
	if(num.test($("#password1").val())){
		$("#num").removeClass("glyphicon-remove");
		$("#num").addClass("glyphicon-ok");
		$("#num").css("color","#00A41E");
	}else{
		$("#num").removeClass("glyphicon-ok");
		$("#num").addClass("glyphicon-remove");
		$("#num").css("color","#FF0004");
	}
	
	if($("#password1").val() == $("#password2").val()){
		$("#pwmatch").removeClass("glyphicon-remove");
		$("#pwmatch").addClass("glyphicon-ok");
		$("#pwmatch").css("color","#00A41E");
	}else{
		$("#pwmatch").removeClass("glyphicon-ok");
		$("#pwmatch").addClass("glyphicon-remove");
		$("#pwmatch").css("color","#FF0004");
	}
});
</script>
</body>
<footer>
  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="https://fastmer.com/"> Fastmer Paraguay</a>
  </div>
  <!-- Copyright -->

</footer>
</html>
