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

<script>
    const currentDate = document.querySelector(".current-date"),
        daysTag = document.querySelector(".days"),
        prevNextIcon = document.querySelectorAll(".icons span");

    let date = new Date(),
        currYear = date.getFullYear(),
        currMonth = date.getMonth(),

        trueYear = date.getFullYear(),
        trueMonth = date.getMonth(),
        trueDate = date.getDate(),

        listaDias = new Array(),
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
        let primera = true;
        for (let i = 0, j = 0; j < 7; i++, j++) {
            if (currWeek != 0 && primera == true) {
                i = currWeek*7;
                primera = false;
            }
            const element = listaDias[i];

            let mes = element.split("/")[0];
            let dia = element.split("/")[1];
            let ano = element.split("/")[2];

            let d = new Date(ano + '-' + mes + '-' + dia).getDay();

            dia = dia.replace(/^(0+)/g, '');

            if (d != 0 && d != 6) { //* QUITAR FINES DE SEMANA
                liTag += `<li id="${element}" class="dia">${dia}</li>`; //!     AÑADE LA FECHA
            }
        }
        primera = true;

        currentDate.innerText = `${months[currMonth]} ${currYear}`;
        daysTag.innerHTML = liTag; //!     ESCRIBE LA FECHA
    }

    renderCalendar(); /* CARGAR AL PRINCIPIO */

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
        let li = document.querySelectorAll(".days li");
        li.forEach(d => {
            if (e.target == d) {
                if (!d.classList.contains("inactive")) {
                    location.href = `${location.origin}/kano/peluquero_reservas.php?fecha=${d.id}&peluquero=${<?php echo $peluquero; ?>}`;
                }
            }
        });
    });
</script>


<?php // include "components/footer.php" ?>