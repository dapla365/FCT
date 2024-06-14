<?php
//* PARA LA PAGINA WEB EN LOCAL
$hostname = "sv1";
$username = "kano";
$password = "kano";
$dbname = "bdkano";

//* PARA LA PAGINA WEB
/*
$hostname = "sql204.thsite.top";
$username = "thsi_35476428";
$password = "********";
$dbname = "thsi_35476428_kano";
*/
// Crear conexión
$mysqli = new mysqli($hostname,$username,$password,$dbname);
$mysqli->set_charset("utf8");
date_default_timezone_set("Europe/Madrid");
?>


