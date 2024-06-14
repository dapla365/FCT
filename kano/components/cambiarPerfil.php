<?php
session_start();
include "user-data2.php";

$type = htmlspecialchars($_POST['type']);
$user = htmlspecialchars($_POST['user']);

$valida = "No se ha podido cambiar correctamente";
switch ($type) {
    case 'username':
        $a = "SELECT * FROM usuarios WHERE username = '$user' AND id != $user_id;";
        $a = mysqli_query($mysqli, $a);

        if (mysqli_num_rows($a) > 0) {
            $valida = '¡Ya hay un usuario con ese usuario!';
        } else {
            $valida = '¡Ya no hay un usuario con ese usuario!';

            $b = "UPDATE usuarios SET username = '$user' WHERE id = '$user_id';";
            $b = mysqli_query($mysqli, $b);

            $_SESSION['usuario'] = $user;

            $valida = "Se ha cambiado correctamente el usuario";
        }
        break;
    case 'nombre':
        $b = "UPDATE usuarios SET nombre = '$user' WHERE id = '$user_id';";
        $b = mysqli_query($mysqli, $b);

        $valida = "Se ha cambiado correctamente el nombre";
        break;
    case 'apellidos':
        $b = "UPDATE usuarios SET apellidos = '$user' WHERE id = '$user_id';";
        $b = mysqli_query($mysqli, $b);

        $valida = "Se ha cambiado correctamente los apellidos";
        break;
    case 'delete':
        $a = "SELECT * FROM usuarios WHERE id = $user_id;";
        $a = mysqli_query($mysqli, $a);
        $rowa = mysqli_fetch_array($a);
        $rol = $rowa["rol"];
        if($rol > 1 && $rol < 4){
            $valida = "No se ha podido eliminar correctamente porque eres peluquero";
            break;
        }else{
            $b = "DELETE FROM usuarios WHERE id = '$user_id'";
            $b = mysqli_query($mysqli, $b);
    
            session_destroy();
        }
        break;
    default:
        $valida = "No se ha podido cambiar correctamente";
        break;
}

echo $valida;

mysqli_close($mysqli);
