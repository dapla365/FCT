<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<div class="centrar">
    <div class="wrapper">
        <header>
            <p class="current-date"><span class="mes">Abril 2024</span>|| <span class="semana"></span></p>
            <div class="icons">
                <span id="prev" class="material-symbols-rounded">
                    <i class="bi bi-chevron-left"></i></span>
                <span class="material-symbols-rounded">
                    <i class="bi bi-chevron-right"></i></span>
            </div>
        </header>
        <div class="calendar">
            <ul class="weeks">
                <li class="domingo">Dom<span class="dias_semana">ingo</span></li>
                <li class="lunes">Lun<span class="dias_semana">es</span></li>
                <li class="martes">Mar<span class="dias_semana">tes</span></li>
                <li class="miercoles">Mié<span class="dias_semana">rcoles</span></li>
                <li class="jueves">Jue<span class="dias_semana">ves</span></li>
                <li class="viernes">Vie<span class="dias_semana">rnes</span></li>
                <li class="sabado">Sab<span class="dias_semana">ado</span></li>
            </ul>
        </div>
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

                if($ano_url > $ano || ($ano_url == $ano && $mes_url > $mes) || ($ano_url == $ano && $mes_url == $mes && $dia_url > $dia)){   //* QUITAR FECHAS ANTERIORES 
                    $fecha = $fecha_url;
                    $dia = $dia_url;
                    $mes = $mes_url;
                    $ano = $ano_url;
                }
            }
            
            $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero';";
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
                        <div class='cita' id='$id'>
                            <div class='cita_datos'>
                                <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                            </div>
                            <div class='cita_datos'>
                                <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                                
                            </div>
                            <div class='cita_datos'>
                                <p class='cita_hora'><i class='bi bi-clock-fill'></i> $hora</p>
                            </div>
                            <div class='cita_opciones'>
                                <button onclick='confirmacion($id)'><i class='bi bi-trash3-fill'></i></button>
                            </div>
                        </div>
                        ";
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
    const currentDate = document.querySelector(".current-date"),
        prevNextIcon = document.querySelectorAll(".icons span");
        
    const lunes = document.querySelector(".lunes"),
        martes = document.querySelector(".martes"),
        miercoles = document.querySelector(".miercoles"),
        jueves = document.querySelector(".jueves"),
        viernes = document.querySelector(".viernes"),
        sabado = document.querySelector(".sabado"),
        domingo = document.querySelector(".domingo");

    let date = new Date(),
        currYear = date.getFullYear(),
        currMonth = date.getMonth(),

        trueYear = date.getFullYear(),
        trueMonth = date.getMonth(),
        trueDate = date.getDate(),

        selectDate = <?php echo "$dia";?>,
        selectMonth = <?php echo "$mes";?>,
        selectYear = <?php echo "$ano";?>,

        listaDias = new Array(),
        currWeek = 0;

    const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
        "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    const days = [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"];

    const renderCalendar = () => {
        lunes.style.fontWeight = "normal";
        martes.style.fontWeight = "normal";
        miercoles.style.fontWeight = "normal";
        jueves.style.fontWeight = "normal";
        viernes.style.fontWeight = "normal";
        sabado.style.fontWeight = "normal";
        domingo.style.fontWeight = "normal";

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
            let fecha = `${dia}/${mes}/${ano}`;

            listaDias.push(fecha);
        }

        //! DIAS DEL MES EN EL QUE ESTAMOS
        for (let i = 1; i <= lastDateofMonth; i++) {
            let mes = currMonth + 1;
            mes = mes.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let dia = i.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let fecha = `${dia}/${mes}/${currYear}`;

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
            let fecha = `${dia}/${mes}/${ano}`;

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

            let dia = element.split("/")[0];
            let mes = element.split("/")[1];
            let ano = element.split("/")[2];

            let trueMonthfecha = (trueMonth+1).toString().padStart(2, '0');
            let trueDatefecha = trueDate.toString().padStart(2, '0');
            let trueYearfecha = trueYear.toString().padStart(2, '0');
            let fecha = `${trueDatefecha}/${trueMonthfecha}/${trueYearfecha}`;  //* DESACTIVAR FECHAS ANTERIORES 

            let selectMonthfecha = selectMonth.toString().padStart(2, '0');
            let selectDatefecha = selectDate.toString().padStart(2, '0');
            let selectYearfecha = selectYear.toString().padStart(2, '0');
            let selectFecha = `${selectDatefecha}/${selectMonthfecha}/${selectYearfecha}`;  //* FECHA ELEGIDA PARA COGER CITA

            let clase = "";
            if(element == selectFecha){   //* FECHA ELEGIDA 
                clase = "active";
            }
            if(trueYearfecha > ano || (trueYearfecha == ano && trueMonthfecha > mes) || (trueYearfecha == ano && trueMonthfecha == mes && trueDatefecha > dia)){   //* QUITAR FECHAS ANTERIORES 
                clase = "inactive";
            }

            let d = new Date(ano + '-' + mes + '-' + dia).getDay();
            dia = dia.replace(/^(0+)/g, '');

            switch (d) {
                case 0:
                    domingo.id = element;
                    domingo.classList = `domingo ${clase}`;
                    break;
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
                case 6:
                    sabado.id = element;
                    sabado.classList = `sabado ${clase}`;
                    break;
                default:
                    break;
            } 

                //TODO REVISAR DIAS COMPLETOS DE CITAS Y DESACTIVARLOS
                /*
                $.ajax({
                    url: 'components/comprobarDiaLibre.php',
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
                });*/

                if (primerDiaSemana == 0) {
                    primerDiaSemana = dia;
                    primerDiaSemanaMes = mes;
                }
                ultimoDiaSemana = dia;
                ultimoDiaSemanaMes = mes;
        }
        primera = true;
        

        currentDate.innerHTML = `<span class='mes'>${months[currMonth]} ${currYear} || </span> <span class='semana'>Semana ${primerDiaSemana}/${primerDiaSemanaMes} - ${ultimoDiaSemana}/${ultimoDiaSemanaMes}</span>`;
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
            if (e.target == d || e.target.parentNode == d) {
                if (!d.classList.contains("inactive")) {
                    location.href = `${location.origin}/kano/peluqueros2.php?fecha=${d.id}&peluquero=${<?php echo $peluquero; ?>}`;
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

<?php include "components/footer.php" ?>