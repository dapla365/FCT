<?php require_once "conexion.php"; ?>
<?php require_once "info.php"; ?>
<?php

$fecha = htmlspecialchars($_POST['fecha']);
$peluquero = htmlspecialchars($_POST['peluquero']);

$options = '';
foreach($horas_disponibles as $x){
    $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero' AND hora = '$x';";
    $a = mysqli_query($mysqli, $a);
    if(mysqli_num_rows($a)>0){
    //* NO HAY CITAS EN ESA FECHA */
        $options .= "inactive";
    }else{
    //* HAY CITAS LIBRES EN ESA FECHA */
        $options .= "";
        break;    
    }   
}
echo $options;

mysqli_close($mysqli);
?>
