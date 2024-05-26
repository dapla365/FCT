<?php include "components/info.php" ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <?php
    session_start();

    if ($_SERVER['PHP_SELF'] != "") {
        $url = explode("/", $_SERVER['PHP_SELF']);
        $url = $url[2];
        //* NAVBAR
        if ($url != 'index.php') {
            echo '            
            <!-- Bootstrap Icon -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <!-- Estilos -->
            <link rel="stylesheet" href="css/navbar.css">';
        }
        //*ESTILOS
        if ($url == 'index.php') {
            echo '
            <!-- Estilos -->
            <link rel="stylesheet" href="css/index.css">';
        }
        if ($url == 'login.php' || $url == 'register.php' || $url == 'changePassword.php') {
            echo '<link rel="stylesheet" href="css/form.css">';
        }
        if ($url == 'editar_user.php') {
            echo '<link rel="stylesheet" href="css/form_user.css">';
        }
        if ($url == 'peluqueros.php' || $url == 'peluqueros2.php') {
            echo '<link rel="stylesheet" href="css/peluqueros.css">';
        }
        if ($url == 'disponibles.php' || $url == 'disponibles2.php') {
            echo '<link rel="stylesheet" href="css/calendario.css">';
        }
        if ($url == 'perfil.php') {
            echo '<link rel="stylesheet" href="css/perfil.css">';
        }
        if ($url == 'reservas.php' || $url == 'editar_citas.php' || $url == 'eliminar_reserva.php' || $url == 'confirmarCita.php') {
            echo '<link rel="stylesheet" href="css/reservas.css">';
        }        
        if ($url == 'admin.php') {
            echo '<link rel="stylesheet" href="css/admin.css">';
        }
        //* JQUERY
        if ($url == 'peluqueros2.php' || $url == 'disponibles.php' || $url == 'disponibles2.php') {
            echo '             
            <!-- JQuery -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
        }
        //* JS
        if ($url == 'disponibles.php') {
            echo '             
            <!-- JS -->
            <script src="js/calendario.js" defer></script>';
        }
    }
    ?>
    
</head>
<body>