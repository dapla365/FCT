<?php
include "conexion.php";

$fecha = htmlspecialchars($_POST['fecha']);
$peluquero = htmlspecialchars($_POST['peluquero']);

$valida = "a";

if($peluquero != null && $peluquero != ""){
    //! PARA PELUQUEROS DISPONIBLES
    $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero' AND usuario IS NULL;";
    $a = mysqli_query($mysqli, $a);
    if(mysqli_num_rows($a)>0){
    //* HAY CITAS DISPONIBLES EN ESA FECHA */
        $valida = 'available';
    }else{
    //* NO HAY CITAS DISPONIBLES EN ESA FECHA */
        $b = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero';";
        $b = mysqli_query($mysqli, $b);
        if(mysqli_num_rows($b)>0){
            $valida = 'filled';
        }
    }  
}else{
    //! PARA CALENDARIO DISPONIBLES
    $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND usuario IS NULL;";
    $a = mysqli_query($mysqli, $a);
    if(mysqli_num_rows($a)>0){
    //* HAY CITAS DISPONIBLES EN ESA FECHA */
        $valida = 'available';
    }else{
    //* NO HAY CITAS DISPONIBLES EN ESA FECHA */
        $b = "SELECT * FROM citas WHERE fecha = '$fecha';";
        $b = mysqli_query($mysqli, $b);
        if(mysqli_num_rows($b)>0){
            $valida = 'filled';
        }
    }  
}
echo $valida;

mysqli_close($mysqli);
