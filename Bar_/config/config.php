<?php
define("KEY_TOKEN","APR.wqc-354*");

define("MONEDA","$");

session_start();

$num_pedi = 0;

if(isset($_SESSION['pedido']['producto'])){

    $num_pedi = count($_SESSION['pedido']['producto']);
}             
