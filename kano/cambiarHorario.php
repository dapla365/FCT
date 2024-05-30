<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<div class="centro">
    <div class="container">
        <form action="" method="post">
            <input type="date" name="fecha" id="fecha" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" required>

            <select name="hora" id="hora">
                <?php
            $hora_inicio = 8;
            $hora_fin = 21;
            for ($hora = $hora_inicio; $hora <= $hora_fin; $hora++) {
                foreach (['00', '30'] as $minuto) {
                    $hora_formateada = $hora.":$minuto";
                    echo "<option value='$hora_formateada'>$hora_formateada</option>";
                }
            }
                ?>
            </select>

            <input type="submit" value="Subir cita">

<?php
            
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];

    $ano = explode("-", $fecha)[0];
    $mes = explode("-", $fecha)[1];
    $dia = explode("-", $fecha)[2];
    
    $dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
    $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
    $ano = str_pad($ano, 2, "0", STR_PAD_LEFT);

    $fecha = $dia ."/". $mes ."/". $ano;

    echo "<br>La fecha seleccionada es: " . htmlspecialchars($fecha) . "<br>";
    echo "La hora seleccionada es: " . htmlspecialchars($hora). "<br>";

    $a = "INSERT INTO citas (fecha, hora, peluquero) VALUES ('$fecha', '$hora', '$user_id')";
    if ($mysqli->query($a) === TRUE) {
        echo "Cita añadida correctamente";
    }
}
            
?>
        </form>
    </div>
</div>
<?php include "components/footer.php" ?>