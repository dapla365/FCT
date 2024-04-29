<?php include "components/info.php" ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- ESTILOS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- JQuery -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    

    <script src="js/datepicker.js"></script>
    <script src="js/calendario.js" defer></script>

    <?php
    session_start();

    if ($_SERVER['PHP_SELF'] != "") {
        $url = explode("/", $_SERVER['PHP_SELF']);
        $url = $url[2];
        if ($url == 'login.php' || $url == 'register.php') {
            echo '<link rel="stylesheet" href="css/form.css">';
        }
        else if ($url == 'peluqueros.php' || $url == 'cita-peluquero.php') {
            echo '<link rel="stylesheet" href="css/peluqueros.css">';
        }
        else if ($url == 'disponibles.php') {
            echo '<link rel="stylesheet" href="css/calendario.css">';
        }
        else if ($url == 'perfil.php') {
            echo '<link rel="stylesheet" href="css/perfil.css">';
        }
        else if ($url == 'reservas.php') {
            echo '<link rel="stylesheet" href="css/reservas.css">';
        }
    }
    ?>

</head>

<body>