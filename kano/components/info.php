<?php
/* INFO */
$title = "KANO | Cut & Shave";
$favicon = "images/favicon.png";
$horario_comienzo=8; 
$horas_trabajo=8;
$horario_salida=20;
$tiempo_pelado = 30;


/* PASAR VARIABLES A INT */
$horario_comienzo = intval($horario_comienzo);
$horas_trabajo = intval($horas_trabajo);
$horario_salida = intval($horario_salida);
$tiempo_pelado = intval($tiempo_pelado);

/* HORAS DISPONIBLES */
$horas_disponibles = array();
for ($i = 0, $j = $horario_comienzo; $j != $horario_salida; $i+=$tiempo_pelado) {
    if($i >= 60) {
        $i = $i % 60;	
        $j++;
    }
    $ii = str_pad($i, 2, "0", STR_PAD_LEFT);
    $y = "$j:$ii";
    array_push($horas_disponibles, $y);
}

?>