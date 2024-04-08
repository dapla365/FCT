<?php
session_set_cookie_params(120);
session_start();
if(isset($_SESSION['usuario'])){
    $user_username=$_SESSION['usuario'];                

    require_once "components/conexion.php";
    $a="SELECT roles.* FROM roles, usuarios WHERE usuarios.username LIKE '$user_username' AND usuarios.rol = roles.id;";   
    $a = mysqli_query($mysqli, $a);
    $a = mysqli_fetch_assoc($a);      

    $user_rolname = $a['nombre'];                       // NOMBRE       DEL ROL
    $user_nivel = $a['nivel'];                          // NIVEL        DEL ROL
    
    $a="SELECT * FROM usuarios WHERE username = '$user_username'";     
    $a = mysqli_query($mysqli, $a);
    $a = mysqli_fetch_assoc($a);
    
    $user_id = $a['id'];                                // ID           DEL USUARIO
    $user_username = $a['username'];                    // USERNAME     DEL USUARIO
    $user_correo = $a['correo'];                        // CORREO       DEL USUARIO
    $user_nombre = $a['nombre'];                        // NOMBRE       DEL USUARIO
    $user_apellidos = $a['apellidos'];                  // APELLIDOS    DEL USUARIO
    $user_rol = $a['rol'];                              // ROL          DEL USUARIO
    $user_foto = $a['foto'];                            // FOTO         DEL USUARIO
    
}
else{
    header("Location: login.php");
    session_abort();
    die();
}
?>