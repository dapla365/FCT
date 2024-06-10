<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<?php
session_start();
if ($user_nivel <= 0) {
    header("Location: index.php");
}

if (isset($_GET['user'])) {
    if ($user_nivel <= 5) {
        $peluquero = $user_id;
    } else {
        $peluquero = htmlspecialchars($_GET['user']);
    }
} else {
    $peluquero = $user_id;
}
$a = "SELECT * FROM usuarios WHERE id='$peluquero';";
$a = mysqli_query($mysqli, $a);
$row = mysqli_fetch_assoc($a);
$peluquero_nombre = $row['nombre'];
$peluquero_apellidos = $row['apellidos'];

?>
<div class="centrar">
    <h2>Horario de <?php echo ucwords($peluquero_nombre) . " " . ucwords($peluquero_apellidos); ?> </h2>
    <div class="calendar">
        <div class="header">
            <button id="prev" onclick="changeMonth(-1)">&#8249;</button>
            <h2 id="month-year"></h2>
            <button id="next" onclick="changeMonth(1)">&#8250;</button>
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

    <div id="buttons">
        <button id="cancel">Cancelar</button>
        <button id="copy">Copiar</button>
        <button id="paste">Pegar</button>
        <button id="edit">Editar</button>
        <button id="delete">Eliminar</button>
    </div>

    <div id="mensaje"></div>
</div>

<script>
    let hayCitas = false;
    let peluquero = "<?php echo $peluquero ?>";
    let copied = null;

    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    const daysContainer = document.getElementById('days');
    const monthYearDisplay = document.getElementById('month-year');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');

    let today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    let displayMonth = currentMonth;
    let displayYear = currentYear;

    function updateCalendar() {
        daysContainer.innerHTML = '';
        const firstDay = new Date(displayYear, displayMonth, 1).getDay();
        const lastDate = new Date(displayYear, displayMonth + 1, 0).getDate();

        monthYearDisplay.textContent = `${monthNames[displayMonth]} ${displayYear}`;

        for (let i = 0; i < firstDay; i++) {
            const emptyDiv = document.createElement('div');
            emptyDiv.classList.add('empty');
            daysContainer.appendChild(emptyDiv);
        }

        for (let day = 1; day <= lastDate; day++) {
            const dayDiv = document.createElement('div');
            const formattedDay = day.toString().padStart(2, '0');
            const formattedMonth = (displayMonth + 1).toString().padStart(2, '0');
            const dateId = `${formattedDay}/${formattedMonth}/${displayYear}`;
            dayDiv.textContent = day;
            dayDiv.id = dateId;
            dayDiv.classList.add('day');

            //* SELECCIONAR LOS DIAS DISPONIBLES
            $.ajax({
                url: 'components/comprobarDiaLibre.php',
                method: 'POST',
                data: {
                    type: 'horario',
                    fecha: dateId,
                    peluquero: peluquero
                },
                success: function(data) {
                    if (data.trim() != "a") {
                        dayDiv.classList.add(data.trim());

                        // Añadir tooltips y clases para días disponibles
                        if (data.trim() == "available") {
                            hayCitas = true;
                            dayDiv.setAttribute('data-tooltip', 'Disponible');
                        }
                    }
                }
            });

            daysContainer.appendChild(dayDiv);
        }

        // Deshabilitar el botón de "anterior" si estamos en el mes actual o un mes posterior
        if (displayYear === currentYear && displayMonth <= currentMonth) {
            prevButton.disabled = true;
        } else {
            prevButton.disabled = false;
        }

        // Deshabilitar el botón de "siguiente" si estamos en el tercer mes en el futuro o más
        if (displayYear > currentYear || (displayYear === currentYear && displayMonth >= currentMonth + 2)) {
            nextButton.disabled = true;
        } else {
            nextButton.disabled = false;
        }
    }

    function changeMonth(step) {
        displayMonth += step;
        if (displayMonth > 11) {
            displayMonth = 0;
            displayYear++;
        } else if (displayMonth < 0) {
            displayMonth = 11;
            displayYear--;
        }
        updateCalendar();
    }

    updateCalendar();

    $(document).on("click", function(e) {
        let div = document.querySelectorAll(".days .day");
        let buttons = document.querySelectorAll("#buttons button");
        let msg = document.getElementById('mensaje');
        let butt = false;

        div.forEach(d => {
            if (e.target == d) {
                if (d.classList.contains('available')) {
                    div.forEach(ds => {
                        if (ds != e.target) {
                            if (ds.classList.contains('selected')) {
                                if (copied != null) {
                                    msg.innerHTML = "<p>¡Este día ya tiene alguna cita!</p><p>¡Borralo antes de pegarle otro día!</p>";
                                    setTimeout(function() {
                                        msg.innerHTML = '';
                                    }, 2000);
                                } else {
                                    ds.classList.toggle('selected');
                                    d.classList.toggle('selected');
                                }
                            } else {
                                if (copied != null) {
                                    msg.innerHTML = "<p>¡Este día ya tiene alguna cita!</p><p>¡Borralo antes de pegarle otro día!</p>";
                                    setTimeout(function() {
                                        msg.innerHTML = '';
                                    }, 2000);
                                } else {
                                    d.classList.toggle('selected');
                                }
                            }
                        }
                    });
                } else if (copied != null) {
                    if (d.id != copied) {
                        d.classList.toggle('selected');
                    }
                } else if (hayCitas == false) {
                    d.classList.toggle('selected');
                    //* QUITAR SELECCIONADO SI HAY ALGUNO YA
                    div.forEach(ds => {
                        if (ds != e.target) {
                            if (ds.classList.contains('selected')) {
                                ds.classList.toggle('selected');
                            }
                        }
                    });

                    document.getElementById('paste').style.display = 'none';
                    document.getElementById('copy').style.display = 'none';
                    document.getElementById('delete').style.display = 'none';
                    
                }
            }
            //* GUARDAR EN VARIABLE EXTERNA PARA QUE NO SE CANCELE AL HABER ALGUNO QUE NO ESTÉ ELEGIDO
            if (d.classList.contains('selected') || copied != null) {
                butt = true;
            }
        });
        //* ENSEÑAR BOTONES DE ACCION
        if (butt) {
            document.getElementById('buttons').style.display = 'flex';
        } else {
            document.getElementById('buttons').style.display = 'none';
            document.getElementById('mensaje').style.display = 'none';
        }

        buttons.forEach(b => {
            if (e.target == b) {
                let m = false;
                let msg = document.getElementById('mensaje');
                div.forEach(d => {
                    if (d.classList.contains('selected')) {
                        m = true;
                    } else if (copied != null && e.target.id == "cancel") {
                        m = true;
                    }
                });
                if (m) {
                    switch (b.id) {
                        case 'copy':
                            msg.innerHTML = "¡Copiado!";
                            document.getElementById('paste').style.display = 'block';
                            document.getElementById('copy').style.display = 'none';
                            document.getElementById('delete').style.display = 'none';
                            div.forEach(d => {
                                if (d.classList.contains('selected')) {
                                    copied = d.id;
                                    d.classList.remove('selected');
                                    d.classList.remove('available');
                                    d.classList.add('filled');
                                }
                            });
                            setTimeout(function() {
                                msg.innerHTML = '';
                            }, 2000);
                            break;
                        case 'paste':
                            if (copied != null) {
                                let paste = [];
                                div.forEach(d => {
                                    if (d.classList.contains('selected')) {
                                        paste.push(d.id);
                                    }
                                });
                                if (paste.length === 0) {
                                    msg.innerHTML = "¡No has seleccionado ningún día!";
                                    setTimeout(function() {
                                        msg.innerHTML = '';
                                    }, 2000);
                                } else if (!paste.includes(copied)) {
                                    paste.forEach(element => {
                                        $.ajax({
                                            url: 'components/comprobarDiaLibre.php',
                                            method: 'POST',
                                            data: {
                                                type: 'pegar',
                                                fecha: copied, //* FECHA QUE QUIERES COPIAR
                                                paste: element, //* FECHAS EN LAS QUE QUIERES PEGAR (ARRAY)
                                                peluquero: peluquero
                                            },
                                            success: function(data) {
                                                location.reload();
                                            }
                                        });
                                    });

                                    msg.innerHTML = "¡Pegado!";
                                    setTimeout(function() {
                                        msg.innerHTML = '';
                                    }, 2000);
                                } else {
                                    msg.innerHTML = "¡No puedes pegar en el mismo día que has copiado!";
                                    setTimeout(function() {
                                        msg.innerHTML = '';
                                    }, 2000);
                                }
                            }

                            break;
                        case 'edit':
                            div.forEach(d => {
                                if (d.classList.contains('selected')) {
                                    location.href = `cambiarHorario2.php?peluquero=${peluquero}&fecha=${d.id}`;
                                }
                            });
                            break;
                        case 'cancel':
                            copied = null;
                            div.forEach(d => {
                                if (d.classList.contains('selected')) {
                                    d.classList.remove('selected');
                                }
                                if (d.classList.contains('filled')) {
                                    d.classList.remove('filled');
                                    d.classList.add('available');
                                }
                            });
                            document.getElementById('delete').style.display = 'block';
                            document.getElementById('copy').style.display = 'block';
                            document.getElementById('paste').style.display = 'none';
                            document.getElementById('buttons').style.display = 'none';
                            document.getElementById('mensaje').style.display = 'none';
                            break;
                        case 'delete':
                            div.forEach(d => {
                                if (d.classList.contains('selected') && copied == null) {
                                    //* ELIMINAR CITAS DE ESE DÍA
                                    $.ajax({
                                        url: 'components/comprobarDiaLibre.php',
                                        method: 'POST',
                                        data: {
                                            type: 'delete',
                                            fecha: d.id, //* FECHA QUE QUIERES ELIMINAR
                                            peluquero: peluquero
                                        },
                                        success: function(data) {
                                            location.reload();
                                        }
                                    });
                                }
                            });
                            break;
                        default:
                            break;
                    }
                } else {
                    copied = null;
                    div.forEach(d => {
                        if (d.classList.contains('selected')) {
                            d.classList.remove('selected');
                        }
                        if (d.classList.contains('filled')) {
                            d.classList.remove('filled');
                            d.classList.add('available');
                        }
                    });
                    document.getElementById('delete').style.display = 'block';
                    document.getElementById('copy').style.display = 'block';
                    document.getElementById('paste').style.display = 'none';
                    document.getElementById('buttons').style.display = 'none';
                    document.getElementById('mensaje').style.display = 'block';

                    msg.innerHTML = "¡No hay ningún día seleccionado!";
                    setTimeout(function() {
                        msg.innerHTML = '';
                    }, 3000);
                }
            }
        });
    });
</script>
<?php include "components/footer.php" ?>