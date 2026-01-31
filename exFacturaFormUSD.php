<?php
//Activamos el almacenamiento en el buffer
ob_start();
setlocale(LC_MONETARY, 'en_US');

if (strlen(session_id()) < 1) 
  session_start();

// Wrapper: renderizamos el mismo template, forzando USD.
$_GET['force_currency'] = 'USD';
require __DIR__ . "/exFacturaForm.php";
ob_end_flush();
?>