<?php
// Recibo en dólares: mismo template que exRecibo.php con moneda forzada USD
$_GET['force_currency'] = 'USD';
require __DIR__ . '/exRecibo.php';
