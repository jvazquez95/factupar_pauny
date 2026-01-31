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
error_reporting(0);
//Librerías para el envío de mail
include_once('class.phpmailer.php');
include_once('class.smtp.php');
//$para = $_POST['email'];
$asunto = 'Robsa S.A - Factura Digital';
//crypt para la contraseña
//$mensaje = $_POST['mensaje'];
//$archivo = $_FILES['fca'];
$nombreCliente = $_GET['nombreCliente'];
$idventanew = $_GET['idventanew'];
$clavehash = $_GET['clavehash'];
$to = $_GET['para'];//$_POST['to'];
$tiposervicio = 'simple';
$hashcarpeta = getenv('HASH_CARPETA_FACTURA') ?: '';
$URL = "http://robsa.com.py/'.$tiposervicio.'/'.$hashcarpeta.'/reportes/exFacturaWeb.php?hash='.$clavehash.'";
//$cuenta = $_POST['cuenta'];
//Este bloque es importante
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPDebug=0;
$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.gmail.com";
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
            <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
              <img src="http://fclero.org.py:8585/ws-2/app/model/maillocalWeb/php/images/logo.jpeg" alt="Creating Email Magic" width="300" height="230" style="display: block;" />
            </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                    <b>Hola '.$nombreCliente.', nos agrada que uses nuestro servicio!</b>
                  </td>
                </tr>
                <tr>
<td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
                                  <table border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;">
                                    <tr>
                                      <td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

					<a href="http://robsa.com.py/syscon/1a5316da4959ba2b6255c005a0010eb6/reportes/exFacturaWeb.php?hash='.$clavehash.'" class="button button--green" target="_blank" style="-webkit-text-size-adjust: none; background: #22BC66; border-color: #22bc66; border-radius: 3px; border-style: solid; border-width: 10px 18px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); box-sizing: border-box; color: #FFF; display: inline-block; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; text-decoration: none;">Click para ver factura digital</a>
					   </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>

                  </td>
                </tr>
                
              </table>
            </td>
          </tr>
          <tr>
            <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                    &reg; Robsa - Todos los derechos reservados<br/>
                    <a href="#" style="color: #ffffff;"><font color="#ffffff">Unsubscribe</font></a> Visitanos en facebook
                  </td>
                  <td align="right" width="25%">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                          <a href="www.facebook.com/RobsaParaguay" style="color: #ffffff;">
                            <img src="http://fclero.org.py:8585/ws-2/app/model/maillocalWeb/php//images/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                          </a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>

';

//$mensaje = 'Sr/a: '. $nombreCliente .', ingrese al siguiente link para poder visualizar o descargar su factura: http://robsa.com.py/uber/v1/reportes/exFacturaWeb.php?id='.$idventanew.'&hash='.$clavehash.  '. Saludos Robsa S.A';
$mail->AddAddress($to);
$mail->Subject = 'Robsa - Factura Digital';
$mail->Subject = $asunto;
$mail->Body = $mensaje;
//Para adjuntar archivo
//$mail->MsgHTML($mensaje);

$resultado = $mail->send();
  	$d = array("estado" => $resultado);

    echo $resultado;
?>

