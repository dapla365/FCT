const currentDate = document.querySelector(".current-date"),
    daysTag = document.querySelector(".days"),
    prevNextIcon = document.querySelectorAll(".icons span");

let date = new Date();
currYear = date.getFullYear();
currMonth = date.getMonth();

trueYear = date.getFullYear();
trueMonth = date.getMonth();
trueDate = date.getDate();

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
        let dia = new Date(currYear + '-' + currMonth + '-' + (lastDateofLastMonth - i + 1)).getDay();
        let mes = currMonth;
        let ano = currYear;
        /* PARA EL CAMBIO DE AÑO */
        if (currMonth == 0) {
            if (currYear > trueYear) {
                dia = new Date((currYear - (currYear - trueYear)) + '-' + 12 + '-' + (lastDateofLastMonth - i + 1)).getDay();
                mes = 12;
                ano = currYear - (currYear - trueYear);
            } else if (currYear == trueYear) {
                dia = new Date((currYear - 1) + '-' + 12 + '-' + (lastDateofLastMonth - i + 1)).getDay();
                mes = 12;
                ano = currYear - 1;
            } else {
                dia = new Date((currYear + (trueYear - currYear)) + '-' + currMonth + '-' + (lastDateofLastMonth - i + 1)).getDay();
                ano = currYear + (trueYear - currYear);
            }
        }
        if (dia != 0 && dia != 6) {
            /* QUITAR FINES DE SEMANA */
            let isLast = (lastDateofLastMonth - i + 1) === trueDate && trueMonth + 1 === currMonth && trueYear === currYear ? "active" : "";

            if ((lastDateofLastMonth - i + 1) < trueDate && trueMonth === currMonth - 1 && trueYear === currYear) {
                /* DIAS ANTERIORES AL QUE ESTAMOS */
                isLast = "inactive";
            }
            if (currYear === trueYear) {
                if (trueMonth >= currMonth) {
                    /* MESES ANTERIORES */
                    isLast = "inactive";
                }
            } else if (currYear > trueYear) {
                isLast = "";
            } else {
                isLast = "inactive";
            }

            mes = mes.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let d = lastDateofLastMonth - i + 1;
            d = d.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let fecha = `${mes}/${d}/${ano}`;

            liTag += `<li id="${fecha}" class="${isLast}">${lastDateofLastMonth - i + 1}</li>`;     //! ESCRIBE LA FECHA

            if (isLast != "inactive") {
                //* PETICION PARA VER SI EL DIA ESTÁ DISPONIBLE
                $.ajax({
                    url: `${location.origin}/kano/components/comprobarDiaLibre.php`,
                    method: 'POST',
                    data: {
                        fecha: fecha
                    },
                    success: function (data) {
                        data = data.replace(/(\r\n|\n|\r)/gm, "");
                        document.getElementById(fecha).classList += data;
                    }
                });
            }
        }
    }

    //! HASTA EL DIA EN EL QUE ESTAMOS
    for (let i = 1; i <= lastDateofMonth; i++) {
        let dia = new Date(currYear + '-' + (currMonth + 1) + '-' + i).getDay();

        if (dia != 0 && dia != 6) {
            /* QUITAR FINES DE SEMANA */
            let isToday = i === date.getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear() ? "active" : "";

            if (i < trueDate && currMonth === new Date().getMonth() && currYear === new Date().getFullYear()) {
                /* DESACTIVAR DIAS ANTERIORES */
                isToday = "inactive";
            }
            if (currYear === trueYear) {
                if (trueMonth > currMonth) {
                    /* DESACTIVAR MESES ANTERIORES */
                    isToday = "inactive";
                }
            } else if (currYear > trueYear) {
                isToday = "";
            } else {
                isToday = "inactive"; /* DESACTIVAR AÑOS ANTERIORES */
            }

            let mes = currMonth + 1;
            mes = mes.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let d = i.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let fecha = `${mes}/${d}/${currYear}`;

            liTag += `<li id="${fecha}" class="${isToday}">${i}</li>`;     //! ESCRIBE LA FECHA

            if (isToday != "inactive") {
                //* PETICION PARA VER SI EL DIA ESTÁ DISPONIBLE
                $.ajax({
                    url: `${location.origin}/kano/components/comprobarDiaLibre.php`,
                    method: 'POST',
                    data: {
                        fecha: fecha
                    },
                    success: function (data) {
                        data = data.replace(/(\r\n|\n|\r)/gm, "");
                        document.getElementById(fecha).classList += data;
                    }
                });
            }

        }
    }

    //! DIAS DEL SIGUIENTE MES
    for (let i = lastDayofMonth; i < 6; i++) {
        let dia = new Date(currYear + '-' + (currMonth + 2) + '-' + (i - lastDayofMonth + 1)).getDay();
        let mes = currMonth + 2;
        let ano = currYear;
        /* PARA EL CAMBIO DE AÑO */
        if (currMonth == 11) {
            if (currYear > trueYear) {
                dia = new Date((currYear + (currYear - trueYear)) + '-' + 1 + '-' + (i - lastDayofMonth + 1)).getDay();
                mes = 1;
                ano = currYear + (currYear - trueYear);
            } else if (currYear == trueYear) {
                dia = new Date((currYear + 1) + '-' + 1 + '-' + (i - lastDayofMonth + 1)).getDay();
                mes = 1;
                ano = currYear + 1;
            } else {
                dia = new Date((currYear - (trueYear - currYear)) + '-' + currMonth + '-' + (i - lastDayofMonth + 1)).getDay();
                ano = currYear - (trueYear - currYear);
            }
        }
        if (dia != 0 && dia != 6) {
            /* QUITAR FINES DE SEMANA */
            let isLast = "";
            if (currYear === trueYear) {
                if (trueMonth > currMonth) {
                    /* DESACTIVAR MESES ANTERIORES */
                    isLast = "inactive";
                }
            } else if (currYear > trueYear) {
                isLast = "";
            } else {
                isLast = "inactive"; /* DESACTIVAR AÑOS ANTERIORES */
            }

            mes = mes.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS
            let d = i - lastDayofMonth + 1;
            d = d.toString().padStart(2, '0'); //* FORMATO 2 DIGITOS

            let fecha = `${mes}/${d}/${ano}`;

            liTag += `<li id="${fecha}" class="${isLast}">${i - lastDayofMonth + 1}</li>`;     //! ESCRIBE LA FECHA

            if (isLast != "inactive") {
                //* PETICION PARA VER SI EL DIA ESTÁ DISPONIBLE
                $.ajax({
                    url: `${location.origin}/kano/components/comprobarDiaLibre.php`,
                    method: 'POST',
                    data: {
                        fecha: fecha
                    },
                    success: function (data) {
                        data = data.replace(/(\r\n|\n|\r)/gm, "");
                        document.getElementById(fecha).classList += data;
                    }
                });
            }
        }
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;
}

renderCalendar(); /* CARGAR AL PRINCIPIO */

/* BOTONES DE CAMBIAR MES */
prevNextIcon.forEach(icon => {
    icon.addEventListener("click", () => {
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if (currMonth < 0 || currMonth > 11) {
            date = new Date(currYear, currMonth);
            currYear = date.getFullYear();
            currMonth = date.getMonth();
        } else {
            date = new Date();
        }
        renderCalendar();
    });
});

const li = document.querySelectorAll("li");
li.forEach(date => {
    date.addEventListener("click", () => {
        if (!date.classList.contains("inactive")) {
            location.href = `${location.origin}/kano/disponibles_reservas.php?fecha=${date.id}`;
        }
    });
});
