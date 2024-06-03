<?php include "components/header.php"; ?>
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    session_abort();
    die();
}
?>
<div class="index_centro">
    <div class="index_container">
        <img src="images/kano.png" alt="logo">
        <a href="peluqueros.php">
            <h2>Peluqueros</h2>
        </a>
        <a href="disponibles.php">
            <h2>Disponibles</h2>
        </a>
        <a href="reservas.php">
            <h2>Reservas</h2>
        </a>
        <a href="perfil.php">
            <h2>Perfil</h2>
        </a>
    </div>
</div>

<?php include "components/footer.php"; ?>