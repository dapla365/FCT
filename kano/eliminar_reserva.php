<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<?php
if (isset($_GET['reserva'])) {
    $id = htmlspecialchars($_GET['reserva']);

    $a = "SELECT * FROM citas WHERE peluquero=$user_id OR usuario=$user_id;";
    $a = mysqli_query($mysqli, $a);
    $b = array();
    while ($row = mysqli_fetch_assoc($a)) {
        array_push($b, $row['id']);
    }

    if (in_array($id, $b)) {
        $c = "DELETE FROM citas WHERE id = '{$id}';";
        $c = mysqli_query($mysqli, $c);
        echo "Reserva eliminada correctamente";
    } else {
        echo "Esa reserva no es tuya o no existe";
    }

    $pagina = $_SERVER['HTTP_REFERER'];
    header("Refresh:3; url=$pagina");
}
?>
<?php include "components/footer.php" ?>