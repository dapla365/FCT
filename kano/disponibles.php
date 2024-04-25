<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<div class="centrar">
    <div class="wrapper">
        <header>
            <p class="current-date">Abril 2024</p>
            <div class="icons">
                <span id="prev" class="material-symbols-rounded">
                    <i class="bi bi-chevron-left"></i></span>
                <span class="material-symbols-rounded">
                    <i class="bi bi-chevron-right"></i></span>
            </div>
        </header>
        <div class="calendar">
            <ul class="weeks">
                <li>Lunes</li>
                <li>Martes</li>
                <li>Miércoles</li>
                <li>Jueves</li>
                <li>Viernes</li>
            </ul>
            <ul class="days">
                <li>1</li>
                <li>2</li>
                <li>3</li>
                <li>4</li>
                <li>7</li>
                <li>8</li>
                <li>9</li>
                <li>10</li>
                <li>11</li>
                <li>12</li>
                <li>13</li>
                <li>14</li>
                <li>15</li>
                <li>18</li>
                <li>19</li>
                <li>20</li>
                <li>21</li>
                <li>22</li>
                <li class="active">23</li>
                <li>24</li>
                <li>25</li>
                <li>26</li>
                <li>27</li>
                <li>30</li>
                <li class="inactive">1</li>
                <li class="inactive">2</li>
                <li class="inactive">3</li>
                <li class="inactive">4</li>
                <li class="inactive">5</li>

            </ul>
        </div>
    </div>
</div>
<div class="disponibles">
    <div class="centro">
        <form action="" method="post">
            <div class="form-group">
                <label for="calendario" class="form-label">Fecha</label>
                <input name="calendario" id='calendario' />
            </div>
            <div class="form-group">
                <label for="horas" class="form-label">Horas disponibles</label>
                <select id="horas" name="horas" class="form-control" disabled></select>
            </div>
            <div class="form-group">
                <input type="submit" name="crear" value="Añadir">
            </div>
            <?php
            if (isset($_POST['crear'])) {
                $calendar = htmlspecialchars($_POST['calendario']);
                $horas = htmlspecialchars($_POST['horas']);

                //* REVISA LAS FECHAS POR SI SON NULL
                //* FECHA SOLUCION 
                if ($calendar == "") {
                    $calendar = 'NULL';
                } else {
                    $calendar = "'" . $calendar . "'";
                }

                if ($horas == "" || $calendar == "" || $calendar == 'NULL') {
                    echo "<p><strong>Error: </strong>¡Tiene que completar los campos obligatorios!</p>";
                } else {
                    //* REVISAMOS QUE LA HORA SELECCIONADA ESTÁ DISPONIBLE
                    if (in_array($horas, $horas_disponibles)) {
                        $peluquero_final = 0;
                        $a = "SELECT * FROM citas WHERE fecha = $calendar AND hora = '$horas';";
                        $a = mysqli_query($mysqli, $a);
                        if (mysqli_num_rows($a) <= 0) {
                            $b = array_rand($peluqueros_totales, 1); //* $peluqueros_totales SE ENCUENTRA EN INFO.PHP
                            $peluquero_final = $peluqueros_totales[$b];
                        } else {
                            $peluqueros_sin_cita = $peluqueros_totales;
                            while ($row = mysqli_fetch_assoc($a)) {
                                $peluquero = $row['peluquero'];
                                $peluqueros_sin_cita = array_diff($peluqueros_sin_cita, array("$peluquero"));
                            }
                            if (count($peluqueros_sin_cita) > 1) {

                                $c = array_rand($peluqueros_sin_cita, 1); //* ELIJE PELUQUERO DISPONIBLE ALEATORIAMENTE
                                $peluquero_final = $peluqueros_sin_cita[$c];
                            } else {
                                foreach ($peluqueros_sin_cita as $x) {
                                    $peluquero_final = $x; //* UNICO PELUQUERO LIBRE.   
                                }
                            }
                        }
                        //* AÑADIR CITA
                        $a = "INSERT INTO citas (fecha, hora, peluquero, usuario) VALUES (" . $calendar . ",'{$horas}','{$peluquero_final}','{$user_id}')";
                        $a = mysqli_query($mysqli, $a);
                        if (!$a) {
                            echo "<p><strong>Error: </strong>Algo ha ido mal añadiendo la incidencia: " . mysqli_error($mysqli) . "</p>";
                        } else {
                            header("Refresh:3; url=index.php");
                            echo "<p> ¡Cita añadida con éxito!. Redirigiendo...</p>";
                            echo "<p> Si no redirige puedes hacer <a href='index.php'>click aquí</a></p>";
                        }
                    } else {
                        echo "<p><strong>Error: </strong>¡Tiene que elegir una hora disponible!</p>";
                    }
                }
            }
            ?>
        </form>
    </div>
</div>

<?php include "components/footer.php" ?>