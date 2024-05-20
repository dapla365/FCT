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
                <li class="lunes">Lunes</li>
                <li class="martes">Martes</li>
                <li class="miercoles">Miércoles</li>
                <li class="jueves">Jueves</li>
                <li class="viernes">Viernes</li>
            </ul>
        </div>
    </div>
</div>

<div class="centro">
    <div class="container">
        <?php
        if (isset($_GET['peluquero'])) {
            $peluquero = mb_strtolower(htmlspecialchars($_GET['peluquero']));

            $a = "SELECT * FROM usuarios WHERE id=$peluquero;";
            $a = mysqli_query($mysqli, $a);
            $row = mysqli_fetch_assoc($a);
            $rol = $row['rol'];
            if ($rol < 1 || $rol > 2) header('Location: peluqueros.php');

            if(isset($_GET['fecha'])){
                $fecha = htmlspecialchars($_GET['fecha']);  
            }else{
                $fecha = date("m/d/Y");
            }
            
            $mes = explode("/", $fecha)[0];
            $dia = explode("/", $fecha)[1];
            $ano = explode("/", $fecha)[2];

            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
            $ano = str_pad($ano, 2, "0", STR_PAD_LEFT);
            $peluquero = htmlspecialchars($_GET['peluquero']);
            
            $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero';";
            $a = mysqli_query($mysqli, $a);
            if(mysqli_num_rows($a)>0){
                //* HAY CITAS EN ESA FECHA */

                $horas_ocupadas = array();
                while ($row = mysqli_fetch_array($a)) {
                    $hora = $row["hora"];
                    array_push($horas_ocupadas, $hora);
                }
                $horas_libres = array_diff_assoc($horas_disponibles, $horas_ocupadas);
                foreach ($horas_libres as $x) {
                    $c = "SELECT * FROM usuarios WHERE id = $peluquero;";
                    $c = mysqli_query($mysqli, $c);
                    $rowc = mysqli_fetch_assoc($c);
                    $peluquero_nombre = ucwords(mb_strtolower($rowc['nombre']));
                    $peluquero_apellido = ucwords(mb_strtolower($rowc['apellidos']));

                    echo "        
                    <a href='confirmarCita.php?fecha=$fecha&hora=$x&peluquero=$peluquero' class='cita' id='$fecha-$x'>
                        <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                        <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                        <p class='cita_hora'><i class='bi bi-clock-fill'></i> $x</p>
                    </a>";
                }
            }else{
                //* NO HAY CITAS EN ESA FECHA */
                foreach ($horas_disponibles as $x) {    
                    $c = "SELECT * FROM usuarios WHERE id = $peluquero;";
                    $c = mysqli_query($mysqli, $c);
                    $rowc = mysqli_fetch_assoc($c);
                    $peluquero_nombre = ucwords(mb_strtolower($rowc['nombre']));
                    $peluquero_apellido = ucwords(mb_strtolower($rowc['apellidos']));

                    echo "        
                    <a href='confirmarCita.php?fecha=$fecha&hora=$x&peluquero=$peluquero' class='cita' id='$fecha-$x'>
                        <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                        <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                        <p class='cita_hora'><i class='bi bi-clock-fill'></i> $x</p>
                    </a>";
                    
                }
            }   
        } else {
            header('Location: peluqueros.php');
        }
        ?>
    </div>
</div>

<script>
    const currentDate = document.querySelector(".current-date"),
        prevNextIcon = document.querySelectorAll(".icons span");
        
    const lunes = document.querySelector(".lunes"),
        martes = document.querySelector(".martes"),
        miercoles = document.querySelector(".miercoles"),
        jueves = document.querySelector(".jueves"),
        viernes = document.querySelector(".viernes");

    let date = new Date(),
        currYear = date.getFullYear(),
        currMonth = date.getMonth(),

        trueYear = date.getFullYear(),
        trueMonth = date.getMonth(),
        trueDate = date.getDate(),

        selectYear = <?php echo "$ano";?>,
        selectMonth = <?php echo "$mes";?>,
        selectDate = <?php echo "$dia";?>,

        listaDias = new Array(),
        currWeek = 0;

    const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
        "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    const days = [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"];

    const renderCalendar = () => {
        lunes.style.fontWeight = "normal";
        martes.style.fontWeight = "normal";
        miercoles.style.fontWeight = "normal";
        jueves.style.fontWeight = "normal";
        viernes.style.fontWeight = "normal";

        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
            lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
            lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
            lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();

        //! DIAS DEL MES ANTERIOR
        for (let i = firstDayofMonth; i > 0; i--) {
            let mes = currMonth;
            let ano = currYear;
            if (currMonth == 0) { //* CAMBIO DE AÑO
                if (currYear > trueYear) {
                    mes = 12;
                    ano = currYear - (currYear - trueYear);
                } else if (currYear == trueYear) {
                    mes = 12;
                    ano = currYear - 1;
                } else {
                    ano = currYear + (trueYear - currYear);
                }
            }

            mes = mes.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let dia = lastDateofLastMonth - i + 1;
            dia = dia.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let fecha = `${mes}/${dia}/${ano}`;

            listaDias.push(fecha);
        }

        //! DIAS DEL MES EN EL QUE ESTAMOS
        for (let i = 1; i <= lastDateofMonth; i++) {
            let mes = currMonth + 1;
            mes = mes.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let dia = i.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let fecha = `${mes}/${dia}/${currYear}`;

            listaDias.push(fecha);
        }

        //! DIAS DEL SIGUIENTE MES
        for (let i = lastDayofMonth; i < 6; i++) {
            let mes = currMonth + 2;
            let ano = currYear;

            if (currMonth == 11) { //* CAMBIO DE AÑO
                if (currYear > trueYear) {
                    mes = 1;
                    ano = currYear + (currYear - trueYear);
                } else if (currYear == trueYear) {
                    mes = 1;
                    ano = currYear + 1;
                } else {
                    ano = currYear - (trueYear - currYear);
                }
            }
            mes = mes.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let dia = i - lastDayofMonth + 1;
            dia = dia.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let fecha = `${mes}/${dia}/${ano}`;

            listaDias.push(fecha);
        }

        //! CARGAR FECHAS EN EL CALENDARIO
        let primera = true;
        let primerDiaSemana = 0;
        let primerDiaSemanaMes = 0;
        let ultimoDiaSemana = 0;
        let ultimoDiaSemanaMes = 0;
        for (let i = 0, j = 0; j < 7; i++, j++) {
            if (currWeek != 0 && primera == true) {
                i = currWeek*7;
                primera = false;
            }
            const element = listaDias[i];

            let mes = element.split("/")[0];
            let dia = element.split("/")[1];
            let ano = element.split("/")[2];

            let trueMonthfecha = (trueMonth+1).toString().padStart(2, '0');
            let trueDatefecha = trueDate.toString().padStart(2, '0');
            let trueYearfecha = trueYear.toString().padStart(2, '0');
            let fecha = `${trueMonthfecha}/${trueDatefecha}/${trueYearfecha}`;  //* DESACTIVAR FECHAS ANTERIORES 

            let selectMonthfecha = selectMonth.toString().padStart(2, '0');
            let selectDatefecha = selectDate.toString().padStart(2, '0');
            let selectYearfecha = selectYear.toString().padStart(2, '0');
            let selectFecha = `${selectMonthfecha}/${selectDatefecha}/${selectYearfecha}`;  //* FECHA ELEGIDA PARA COGER CITA

            let clase = "";
            if(element == selectFecha){   //* FECHA ELEGIDA 
                clase = "active";
            }
            if(element < fecha){   //* QUITAR FECHAS ANTERIORES 
                clase = "inactive";
            }

            let d = new Date(ano + '-' + mes + '-' + dia).getDay();
            dia = dia.replace(/^(0+)/g, '');

            if (d != 0 && d != 6) { //* QUITAR FINES DE SEMANA
                switch (d) {
                    case 1:
                        lunes.id = element;
                        lunes.classList = `lunes ${clase}`;
                        break;
                    case 2:
                        martes.id = element;
                        martes.classList = `martes ${clase}`;
                        break;
                    case 3:
                        miercoles.id = element;
                        miercoles.classList = `miercoles ${clase}`;
                        break;
                    case 4:
                        jueves.id = element;
                        jueves.classList = `jueves ${clase}`;
                        break;
                    case 5:
                        viernes.id = element;
                        viernes.classList = `viernes ${clase}`;
                        break;
                    default:
                        break;
                }

                //TODO REVISAR DIAS COMPLETOS DE CITAS Y DESACTIVARLOS
                $.ajax({
                    url: 'components/peluquero_reservas.php',
                    method: 'POST',
                    data: {
                        fecha: element,
                        peluquero: <?php echo "$peluquero";?>
                    },
                    success: function(data) {
                        let d = document.getElementById(element).classList;
                        if(!d.contains("inactive") && !d.contains("active")){
                            d = data;
                        }
                    }
                });

                if (primerDiaSemana == 0) {
                    primerDiaSemana = dia;
                    primerDiaSemanaMes = mes;
                }
                ultimoDiaSemana = dia;
                ultimoDiaSemanaMes = mes;
            }
        }
        primera = true;

        currentDate.innerText = `${months[currMonth]} ${currYear}  ||  Semana ${primerDiaSemana}/${primerDiaSemanaMes} - ${ultimoDiaSemana}/${ultimoDiaSemanaMes}`;
    }

    //! CARGAR AL PRINCIPIO 
    currWeek = getWeekOfMonth(selectYear, selectMonth-1, selectDate);
    currMonth = selectMonth-1;
    currYear = selectYear;
    renderCalendar(); 

    /* BOTONES DE CAMBIAR MES */
    prevNextIcon.forEach(icon => {
        icon.addEventListener("click", () => {
            currWeek = icon.id === "prev" ? currWeek - 1 : currWeek + 1;
            let maxWeek = Math.trunc(new Date(currYear, currMonth, 0).getDate()/7);
            if (currWeek < 0) {
                currMonth--;
                currWeek = maxWeek;

                if (currMonth < 0 || currMonth > 11) {
                    date = new Date(currYear, currMonth);
                    currYear = date.getFullYear();
                    currMonth = date.getMonth();
                } else {
                    date = new Date();
                }
            }else if(currWeek > maxWeek){
                currWeek = 0;
                currMonth++;
                if (currMonth < 0 || currMonth > 11) {
                    date = new Date(currYear, currMonth);
                    currYear = date.getFullYear();
                    currMonth = date.getMonth();
                } else {
                    date = new Date();
                }
            }
            listaDias = new Array();

            renderCalendar();
        });
    });

    $(document).on("click", function(e) { //*     SE HACE POR DOCUMENTO PARA CUANDO SE CAMBIE LA PAGINA SE PUEDA COMPROBAR DE NUEVO
        let li = document.querySelectorAll(".weeks li");
        li.forEach(d => {
            if (e.target == d) {
                if (!d.classList.contains("inactive")) {
                    location.href = `${location.origin}/kano/cita-peluquero.php?fecha=${d.id}&peluquero=${<?php echo $peluquero; ?>}`;
                }
            }
        });
    });

    function getWeekOfMonth(year, month, day) {
        let firstDay = new Date(year, month, 1);
        let firstDayOfWeek = firstDay.getDay();
        let currentDate = new Date(year, month, day);
        let dayOfMonth = currentDate.getDate();
        let weekNumber = Math.trunc((dayOfMonth + firstDayOfWeek - 1) / 7);
        
        return weekNumber;
    }
</script>


<?php // include "components/footer.php" ?>