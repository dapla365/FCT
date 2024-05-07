<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<?php

if (isset($_GET['peluquero'])) {
    $peluquero = mb_strtolower(htmlspecialchars($_GET['peluquero']));

    $a = "SELECT * FROM usuarios WHERE id=$peluquero;";
    $a = mysqli_query($mysqli, $a);
    $row = mysqli_fetch_assoc($a);
    $rol = $row['rol'];
    if ($rol < 1 || $rol > 2) header('Location: peluqueros.php');
} else {
    header('Location: peluqueros.php');
}
?>

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

            </ul>
        </div>
    </div>
</div>


<div class="peluqueros">
    <div class="centro">
        <form action="" method="post">
            <div class="form-group">
                <label for="calendar" class="form-label">Fecha</label>
                <input name="calendar" id='calendar' />
            </div>
            <div class="form-group">
                <label for="hours" class="form-label">Horas disponibles</label>
                <select id="hours" name="hours" class="form-control" disabled>
                    <option value="Elije una fecha">Elije una fecha</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="crear" value="Añadir">
            </div>
            <?php
            if (isset($_POST['crear'])) {
                $calendar = htmlspecialchars($_POST['calendar']);
                $horas = htmlspecialchars($_POST['hours']);

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
                    //TODO FALTA COMPROBAR HORAS DISPONIBLES 
                    $a = "INSERT INTO citas (fecha, hora, peluquero, usuario) VALUES (" . $calendar . ",'{$horas}','{$peluquero}','{$user_id}')";
                    $a = mysqli_query($mysqli, $a);
                    if (!$a) {
                        echo "<p><strong>Error: </strong>Algo ha ido mal añadiendo la incidencia: " . mysqli_error($mysqli) . "</p>";
                    } else {
                        header("Refresh:3; url=index.php");
                        echo "<p> ¡Cita añadida con éxito!. Redirigiendo...</p>";
                        echo "<p> Si no redirige puedes hacer <a href='index.php'>click aquí</a></p>";
                    }
                }
            }
            ?>
        </form>
    </div>
</div>


<script>
    const currentDate = document.querySelector(".current-date"),
        daysTag = document.querySelector(".days"),
        prevNextIcon = document.querySelectorAll(".icons span");

    let date = new Date();
    currYear = date.getFullYear();
    currMonth = date.getMonth();

    trueYear = date.getFullYear();
    trueMonth = date.getMonth();
    trueDate = date.getDate();

    listaDias = new Array();
    currWeek = 0;

    const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
        "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    const renderCalendar = () => {
        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
            lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
            lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
            lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();
        let liTag = "";

        //! DIAS DEL MES ANTERIOR
        for (let i = firstDayofMonth; i > 0; i--) {
            listaDias.push(lastDateofLastMonth - i + 1);

        }

        //! DIAS DEL MES EN EL QUE ESTAMOS
        for (let i = 1; i <= lastDateofMonth; i++) {
            listaDias.push(i);
        }

        //! DIAS DEL SIGUIENTE MES
        for (let i = lastDayofMonth; i < 6; i++) {
            listaDias.push(i - lastDayofMonth + 1);
        }

        currentDate.innerText = `${months[currMonth]} ${currYear}`;
        daysTag.innerHTML = liTag;
    }

    renderCalendar(); /* CARGAR AL PRINCIPIO */

    /* BOTONES DE CAMBIAR MES */
    prevNextIcon.forEach(icon => {
        icon.addEventListener("click", () => {
            currWeek = icon.id === "prev" ? currWeek - 1 : currWeek + 1;

            let maxWeek = listaDias.length/7;

            if (currWeek < 0) {
                currMonth--;
                if (currMonth < 0 || currMonth > 11) {
                    date = new Date(currYear, currMonth);
                    currYear = date.getFullYear();
                    currMonth = date.getMonth();
                } else {
                    date = new Date();
                }
            }
            else if (currWeek > maxWeek-1) {
                currMonth++;
                if (currMonth < 0 || currMonth > 11) {
                    date = new Date(currYear, currMonth);
                    currYear = date.getFullYear();
                    currMonth = date.getMonth();
                } else {
                    date = new Date();
                }
            }

            renderCalendar();
        });
    });

    $(document).on("click", function(e) { //*     SE HACE POR DOCUMENTO PARA CUANDO SE CAMBIE LA PAGINA SE PUEDA COMPROBAR DE NUEVO
        let li = document.querySelectorAll(".days li");
        li.forEach(d => {
            if (e.target == d) {
                if (!d.classList.contains("inactive")) {
                    location.href = `${location.origin}/kano/disponibles_reservas.php?fecha=${d.id}`;
                }
            }
        });
    });
</script>


<?php include "components/footer.php" ?>