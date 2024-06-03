<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<div class="centrar">
    <div class="calendar">
        <div class="header">
            <button id="prev" onclick="changeWeek(-1)">&#8249;</button>
            <h2 id="week-range"></h2>
            <button id="next" onclick="changeWeek(1)">&#8250;</button>
        </div>
        <div class="weekdays">
            <div>Dom</div>
            <div>Lun</div>
            <div>Mar</div>
            <div>Mié</div>
            <div>Jue</div>
            <div>Vie</div>
            <div>Sáb</div>
        </div>
        <div class="days" id="days"></div>
    </div>
</div>

<div class="centro">
    <div class="container">
        <?php
        if (isset($_GET['peluquero'])) {
            $peluquero = htmlspecialchars($_GET['peluquero']);
            $disp = TRUE;

            $a = "SELECT * FROM usuarios WHERE id=$peluquero;";
            $a = mysqli_query($mysqli, $a);
            $row = mysqli_fetch_assoc($a);
            $rol = $row['rol'];
            if ($rol < 1 || $rol > 2) header('Location: peluqueros.php');

            $fecha = date("d/m/Y");
            $dia = explode("/", $fecha)[0];
            $mes = explode("/", $fecha)[1];
            $ano = explode("/", $fecha)[2];

            $dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $ano = str_pad($ano, 2, "0", STR_PAD_LEFT);

            if(isset($_GET['fecha'])) {
                $fecha_url = htmlspecialchars($_GET['fecha']);  
                $dia_url = explode("/", $fecha_url)[0];
                $mes_url = explode("/", $fecha_url)[1];
                $ano_url = explode("/", $fecha_url)[2];

                if($ano_url > $ano || ($ano_url == $ano && $mes_url > $mes) || ($ano_url == $ano && $mes_url == $mes && $dia_url >= $dia)){   //* QUITAR FECHAS ANTERIORES 
                    $fecha = $fecha_url;
                    $dia = $dia_url;
                    $mes = $mes_url;
                    $ano = $ano_url;
                }else{
                    echo "<script>alert('No se puede seleccionar un día que ya ha pasado')</script>";
                }
            }
            
            $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero' AND usuario IS NULL;";
            $a = mysqli_query($mysqli, $a);
            if(mysqli_num_rows($a)>0){
                //* HAY CITAS EN ESA FECHA */
                while ($row = mysqli_fetch_assoc($a)) {
                    $id = $row['id'];
                    $fecha = $row['fecha'];
                    $hora = $row['hora'];
                    $peluquero = $row['peluquero'];
                    $usuario = $row['usuario'];
    
                    if($fecha == date("d/m/Y")){
                        $hora_hoy = date("H:i", time());
                        $hh = explode(":", $hora)[0]; 
                        $mm = explode(":", $hora)[1]; 
                        $hh_hoy = explode(":", $hora_hoy)[0]; 
                        $mm_hoy = explode(":", $hora_hoy)[1]; 

                        if($hh < $hh_hoy || ($hh == $hh_hoy && $mm < $mm_hoy)){
                            $usuario = 0;
                        }
                    }

                    if($usuario == NULL){
                        $disp = FALSE;
                        /* INFO PELUQUERO */
                        $b = "SELECT * FROM usuarios WHERE id=$peluquero;";
                        $b = mysqli_query($mysqli, $b);
                        $rowb = mysqli_fetch_assoc($b);
                        $peluquero_nombre = ucwords(mb_strtolower($rowb['nombre']));
                        $peluquero_apellido = ucwords(mb_strtolower($rowb['apellidos']));
                        
                        echo "        
                        <a href='confirmarCita.php?fecha=$fecha&hora=$hora&peluquero=$peluquero' class='cita' id='$fecha-$hora'>
                            <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre&nbsp;<span class='apellidos'>$peluquero_apellido<span></p>
                            <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                            <p class='cita_hora'><i class='bi bi-clock-fill'></i> $hora</p>
                        </a>";
                    }
                }

                if($disp) {
                    echo "<a href='disponibles.php' class='sin_citas'><i class='bi bi-calendar-fill'></i> No hay citas disponibles</a>";
                }
            }else{
                //* NO HAY CITAS EN ESA FECHA */
                echo "<a href='disponibles.php' class='sin_citas'><i class='bi bi-calendar-fill'></i> No hay citas en esta fecha</a>";
            }   
        } else {
            header('Location: peluqueros.php');
        }
        ?>
    </div>
</div>


<script>
const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
const daysContainer = document.getElementById('days');
const weekRangeDisplay = document.getElementById('week-range');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');

//* FECHA TIPO 'MES / DIA / AÑO'
let fecha = "<?php echo $mes."/".$dia."/".$ano;?>";

let selectedDate = new Date(fecha);
let today = new Date();
let currentWeekStart = new Date(today.setDate(today.getDate() - today.getDay()));
let displayWeekStart = new Date(selectedDate.setDate(selectedDate.getDate() - selectedDate.getDay()));
let maxFutureDate = new Date();
maxFutureDate.setMonth(maxFutureDate.getMonth() + 2);

function updateCalendar() {
    daysContainer.innerHTML = '';
    let weekStart = new Date(displayWeekStart);
    let weekEnd = new Date(weekStart);
    weekEnd.setDate(weekEnd.getDate() + 6);

    weekRangeDisplay.textContent = `${weekStart.getDate()} ${monthNames[weekStart.getMonth()]} ${weekStart.getFullYear()} - ${weekEnd.getDate()} ${monthNames[weekEnd.getMonth()]} ${weekEnd.getFullYear()}`;

    for (let i = 0; i < 7; i++) {
        let day = new Date(weekStart);
        day.setDate(day.getDate() + i);
        const dayDiv = document.createElement('div');
        dayDiv.textContent = day.getDate();
        const formattedDay = day.getDate().toString().padStart(2, '0');
        const formattedMonth = (day.getMonth() + 1).toString().padStart(2, '0');
        const dateId = `${formattedDay}/${formattedMonth}/${day.getFullYear()}`;
        dayDiv.id = dateId;
        dayDiv.classList.add('day');

        if (day.toDateString() === new Date().toDateString()) {
            dayDiv.classList.add('today');
        }

        //* DIAS LLENOS Y DISPONIBLES
        $.ajax({
            url: 'components/comprobarDiaLibre.php',
            method: 'POST',
            data: {
                fecha: dateId,
                peluquero: <?php echo "$peluquero";?>
            },
            success: function(data) {
                if(data.trim() != "a"){
                    dayDiv.classList.add(data.trim());
                    // Añadir tooltips y clases para días llenos y disponibles
                    if(data.trim() == "available"){
                        dayDiv.setAttribute('data-tooltip', 'Disponible');
                    }else if(data.trim() == "filled"){
                        dayDiv.setAttribute('data-tooltip', 'Lleno');
                    }
                }
            }
        });

        daysContainer.appendChild(dayDiv);
    }

    // Deshabilitar el botón "anterior" si estamos en la semana actual
    if (displayWeekStart <= currentWeekStart) {
        prevButton.disabled = true;
    } else {
        prevButton.disabled = false;
    }

    // Deshabilitar el botón "siguiente" si estamos más allá de dos meses desde la fecha actual
    let nextWeekStart = new Date(displayWeekStart);
    nextWeekStart.setDate(nextWeekStart.getDate() + 7);
    if (nextWeekStart > maxFutureDate) {
        nextButton.disabled = true;
    } else {
        nextButton.disabled = false;
    }
}

function changeWeek(step) {
    displayWeekStart.setDate(displayWeekStart.getDate() + step * 7);
    updateCalendar();
}

updateCalendar();

//* REDIRIGIR A LA CITA DISPONIBLES
$(document).on("click", function(e) { //*     SE HACE POR DOCUMENTO PARA CUANDO SE CAMBIE LA PAGINA SE PUEDA COMPROBAR DE NUEVO
    let div = document.querySelectorAll(".days div");
    div.forEach(d => {
        if (e.target == d) {
            location.href = `${location.origin}/kano/peluqueros2.php?fecha=${d.id}&peluquero=${<?php echo $peluquero; ?>}`;
        }
    });
});
</script>

<?php include "components/footer.php" ?>