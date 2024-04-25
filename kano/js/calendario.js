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
    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
        lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
        lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
        lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();
    let liTag = "";

    /*TODO FALTA COMPROBAR LOS DIAS QUE TIENEN OCUPADOS LOS PELUQUEROS */

    /* DIAS DEL MES ANTERIOR */
    for (let i = firstDayofMonth; i > 0; i--) {
        let dia = new Date(currYear + '-' + currMonth + '-' + (lastDateofLastMonth - i + 1)).getDay();

        /* PARA EL CAMBIO DE AÑO */
        if (currMonth == 0) {
            if (currYear > trueYear) {
                dia = new Date((currYear - (currYear - trueYear)) + '-' + 12 + '-' + (lastDateofLastMonth - i + 1)).getDay();
            } else if (currYear == trueYear) {
                dia = new Date((currYear - 1) + '-' + 12 + '-' + (lastDateofLastMonth - i + 1)).getDay();
            } else {
                dia = new Date((currYear + (trueYear - currYear)) + '-' + currMonth + '-' + (lastDateofLastMonth - i + 1)).getDay();
            }
            /*
            const dayNames = ["Sunday", "Monday", "Tuesday", "Wed", "Thur", "Fri", "Sat"];
            console.log((currYear - 1) + " - " + dayNames[dia] + ", " + (lastDateofLastMonth - i + 1));
            */
        }


        if (dia != 0 && dia != 6) {         /* QUITAR FINES DE SEMANA */
            let isLast = (lastDateofLastMonth - i + 1) === trueDate && trueMonth + 1 === currMonth && trueYear === currYear ? "active" : "";

            if ((lastDateofLastMonth - i + 1) < trueDate && trueMonth === currMonth - 1 && trueYear === currYear) { /* DIAS ANTERIORES AL QUE ESTAMOS */
                isLast = "inactive";
            }
            if (currYear === trueYear) {
                if (trueMonth >= currMonth) { /* MESES ANTERIORES */
                    isLast = "inactive";
                }
            } else if (currYear > trueYear) {
                isLast = "";
            } else {
                isLast = "inactive";
            }
            liTag += `<li class="${isLast}">${lastDateofLastMonth - i + 1}</li>`;
        }
    }

    /* HASTA EL DIA EN EL QUE ESTAMOS */
    for (let i = 1; i <= lastDateofMonth; i++) {
        let dia = new Date(currYear + '-' + (currMonth + 1) + '-' + i).getDay();

        if (dia != 0 && dia != 6) {         /* QUITAR FINES DE SEMANA */
            let isToday = i === date.getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear() ? "active" : "";

            if (i < trueDate && currMonth === new Date().getMonth() && currYear === new Date().getFullYear()) { /* DESACTIVAR DIAS ANTERIORES */
                isToday = "inactive";
            }
            if (currYear === trueYear) {
                if (trueMonth > currMonth) { /* DESACTIVAR MESES ANTERIORES */
                    isToday = "inactive";
                }
            } else if (currYear > trueYear) {
                isToday = "";
            } else {
                isToday = "inactive";    /* DESACTIVAR AÑOS ANTERIORES */
            }
            liTag += `<li class="${isToday}">${i}</li>`;
        }
    }

    /* DIAS DEL SIGUIENTE MES */
    for (let i = lastDayofMonth; i < 6; i++) {
        let dia = new Date(currYear + '-' + (currMonth + 2) + '-' + (i - lastDayofMonth + 1)).getDay();

        /* PARA EL CAMBIO DE AÑO */
        if (currMonth == 11) {
            if (currYear > trueYear) {
                dia = new Date((currYear + (currYear - trueYear)) + '-' + 1 + '-' + (i - lastDayofMonth + 1)).getDay();
            } else if (currYear == trueYear) {
                dia = new Date((currYear + 1) + '-' + 1 + '-' + (i - lastDayofMonth + 1)).getDay();
            } else {
                dia = new Date((currYear - (trueYear - currYear)) + '-' + currMonth + '-' + (i - lastDayofMonth + 1)).getDay();
            }
            /*
            const dayNames = ["Sunday", "Monday", "Tuesday", "Wed", "Thur", "Fri", "Sat"];
            console.log((currYear + 1) + " - " +dayNames[dia]+", "+(i - lastDayofMonth + 1));
            */
        }

        if (dia != 0 && dia != 6) {         /* QUITAR FINES DE SEMANA */
            let isLast = "";
            if (currYear === trueYear) {
                if (trueMonth > currMonth) { /* DESACTIVAR MESES ANTERIORES */
                    isLast = "inactive";
                }
            } else if (currYear > trueYear) {
                isLast = "";
            } else {
                isLast = "inactive";    /* DESACTIVAR AÑOS ANTERIORES */
            }

            liTag += `<li class="${isLast}">${i - lastDayofMonth + 1}</li>`;
        }
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;
}
renderCalendar();   /* CARGAR AL PRINCIPIO */

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