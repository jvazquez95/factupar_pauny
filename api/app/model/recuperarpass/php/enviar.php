<?php
if (file_exists(__DIR__ . '/../../../../../config/load_env.php')) { require __DIR__ . '/../../../../../config/load_env.php'; }
// Specify domains from which requests are allowed
header('Access-Control-Allow-Origin: *');



// Specify which request methods are allowed

header('Access-Control-Allow-Methods: *');



// Additional headers which may be sent along with the CORS request

// The X-Requested-With header allows jQuery requests to go through

header('Access-Control-Allow-Headers: *');



// Set the age to 1 day to improve speed/caching.

header('Access-Control-Max-Age: 86400');

//error_reporting(0);

//Librerías para el envío de mail

include_once('class.phpmailer.php');

include_once('class.smtp.php');

//$para = $_POST['email'];

$asunto = 'Recuperacion de contraseña - Fastmer Riders';

//crypt para la contraseña

//$mensaje = $_POST['mensaje'];

//$archivo = $_FILES['fca'];

$nombre = $_GET['nombre'];

$codigo = $_GET['codigo'];

$to =     $_GET['email'];//$_POST['to'];

//$cuenta = $_POST['cuenta'];

//Este bloque es importante

$mail = new PHPMailer();

$mail->IsSMTP();

$mail->SMTPAuth = true;

$mail->SMTPDebug=0;

$mail->SMTPSecure = "ssl";

$mail->Host = "mail.robsa.com.py";

$mail->Port = 465;

$mail->CharSet = "UTF-8";

//Nuestra cuenta
$mail->Username = getenv('SMTP_USERNAME') ?: '';
$mail->Password = getenv('SMTP_PASSWORD') ?: '';

$mail->isHTML(true);


$mensaje = '



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Demystifying Email Design</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>

<body style="margin: 0; padding: 0;">

  <table border="0" cellpadding="0" cellspacing="0" width="100%"> 

    <tr>

      <td style="padding: 10px 0 30px 0;">

        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">

          <tr>

            <td>

              <img src="https://robsa.com.py/fastmer/assets/contra_mail.jpg" alt="Creating Email Magic" width="700" height="300" />

            </td>

          </tr>

          <tr>

            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">

              <table border="0" cellpadding="0" cellspacing="0" width="100%">

                <tr>

                  <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">

                    <b> Sr/a. '.$nombre.' ingrese al siguiente enlace para actualizar su contraseña: https://robsa.com.py/fastmer/servicios/app/model/maillocalWeb/php/cambiar_password.php?codigo='.$codigo.'</b>

                  </td>

                </tr>

        </table>

      </td>

    </tr>

  </table>

</body>

</html>



';

$mail->AddAddress($to);

$mail->Subject = 'Recuperación de contraseña - Fastmer Drive';

$mail->Subject = $asunto;

$mail->Body = $mensaje;

//Para adjuntar archivo

//$mail->MsgHTML($mensaje);



$resultado = $mail->send();

  	$d = array("estado" => $resultado);



    echo $resultado;

?>



