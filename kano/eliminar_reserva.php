<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<div class="centro">
    <div class="container">
<?php
if (isset($_GET['reserva'])) {
    $id = htmlspecialchars($_GET['reserva']);

    $a = "SELECT * FROM citas WHERE peluquero=$user_id OR usuario=$user_id;";
    $a = mysqli_query($mysqli, $a);
    $b = array();
    while ($row = mysqli_fetch_assoc($a)) {
        array_push($b, $row['id']);
    }

    if (in_array($id, $b) || $user_nivel > 5) {
        $c = "UPDATE citas SET usuario = NULL WHERE id = '$id';";
        $c = mysqli_query($mysqli, $c);
        echo "<div class='sin_citas'>Reserva eliminada correctamente</div>";
    } else {
        echo "<div class='sin_citas'>¡Esa reserva no es tuya o no existe!</div>";
    }

    $pagina = $_SERVER['HTTP_REFERER'];
    $parsed_url = parse_url($pagina);
    $path = $parsed_url['path'];
    $file = basename($path);
    if($file == "login.php" || $file == "eliminar_reserva.php") {
        $file = "index.php";
    }else{
        $file = $pagina;
    }

    header("Refresh:2; url=$file");
}
else if (isset($_GET['realizada'])) {
    $id = htmlspecialchars($_GET['realizada']);

    $a = "SELECT * FROM citas WHERE peluquero=$user_id OR usuario=$user_id;";
    $a = mysqli_query($mysqli, $a);
    $b = array();
    while ($row = mysqli_fetch_assoc($a)) {
        array_push($b, $row['id']);
    }

    if (in_array($id, $b) || $user_nivel > 5) {
        $c = "UPDATE citas SET realizada = TRUE WHERE id = '$id';";
        $c = mysqli_query($mysqli, $c);
        echo "<div class='sin_citas'>Reserva realizada correctamente</div>";
    } else {
        echo "<div class='sin_citas'>¡Esa reserva no es tuya o no existe!</div>";
    }

    $pagina = $_SERVER['HTTP_REFERER'];
    $parsed_url = parse_url($pagina);
    $path = $parsed_url['path'];
    $file = basename($path);
    if($file == "login.php" || $file == "eliminar_reserva.php") {
        $file = "index.php";
    }else{
        $file = $pagina;
    }

    header("Refresh:2; url=$file");
}
else if (isset($_GET['delete'])) {
    $id = htmlspecialchars($_GET['delete']);

    if ($user_nivel >= 5) {
        $c = "DELETE FROM citas WHERE id = '{$id}';";
        $c = mysqli_query($mysqli, $c);
    }

    $pagina = $_SERVER['HTTP_REFERER'];
    $parsed_url = parse_url($pagina);
    $path = $parsed_url['path'];
    $file = basename($path);
    if($file == "login.php" || $file == "eliminar_reserva.php") {
        $file = "index.php";
    }else{
        $file = $pagina;
    }

    header("Refresh:2; url=$file");
}

?>
    </div>
</div>
<?php include "components/footer.php" ?>