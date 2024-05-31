<?php
include "info.php";
include "conexion.php";

$fecha = htmlspecialchars($_POST['fecha']);
$peluquero = htmlspecialchars($_POST['peluquero']);

$valida = '';

if($peluquero != null && $peluquero != ""){
    $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero' AND usuario IS NULL;";
    $a = mysqli_query($mysqli, $a);
    if(mysqli_num_rows($a)>0){
    //* HAY CITAS LIBRES EN ESA FECHA */
        $valida = '';
    }else{
    //* NO HAY CITAS LIBRES EN ESA FECHA */
        $valida = 'inactive';    
    }  
}else{
    $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND usuario IS NULL;";
    $a = mysqli_query($mysqli, $a);
    if(mysqli_num_rows($a)>0){
    //* HAY CITAS LIBRES EN ESA FECHA */
        $valida = '';
    }else{
    //* NO HAY CITAS LIBRES EN ESA FECHA */
        $valida = 'inactive';    
    }  
}
echo $valida;

mysqli_close($mysqli);
