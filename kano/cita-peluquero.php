<?php
include "components/header.php";
include "components/navbar.php";
require_once 'components/conexion.php';

if (isset($_GET['peluquero'])) {
    $peluquero = mb_strtolower(htmlspecialchars($_GET['peluquero']));

    $a = "SELECT * FROM usuarios WHERE id=$peluquero;";
    $a = mysqli_query($mysqli, $a);
    $row = mysqli_fetch_assoc($a);
    $rol = $row['rol'];
    if ($rol < 1 && $rol > 2) header('Location: peluqueros.php');

} else {
    header('Location: peluqueros.php');
}
?>

<div class="peluqueros">
    <div class="centro">
        <form action="" method="post">
            <div class="form-group">
                <label for="datepicker" class="form-label">Fecha</label>
                <input name="datepicker" id='calendar' />
            </div>
            <div class="form-group">
                <label for="aula" class="form-label">Horas disponibles</label>
                <select id="aula" name="aula" class="form-control">
                    <?php
                    /*
                    $a = "SELECT * FROM plantas";
                    $a = mysqli_query($mysqli, $a);
                    while ($row = mysqli_fetch_assoc($a)) {
                        $plantaid = $row['id'];
                        $b = "SELECT * FROM aulas WHERE planta = '$plantaid'";
                        $b = mysqli_query($mysqli, $b);

                        while ($rowb = mysqli_fetch_assoc($b)) {
                            $planta = ucfirst(mb_strtolower($rowb['aula']));
                            echo "<option value='$planta'>$planta</option>";
                        }
                        break;
                    }
                    */
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="crear" class="btn btn-primary mt-2" value="Añadir">
            </div>
        </form>
    </div>
</div>

<?php include "components/footer.php" ?>