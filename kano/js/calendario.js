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
        
        if (day === today.getDate() && displayMonth === today.getMonth() && displayYear === today.getFullYear()) {
            dayDiv.classList.add('today');
        }

        //* DIAS LLENOS Y DISPONIBLES
        $.ajax({
            url: 'components/comprobarDiaLibre.php',
            method: 'POST',
            data: {
                fecha: dateId
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

//* REDIRIGIR A LA CITA DISPONIBLES
$(document).on("click", function(e) { //*     SE HACE POR DOCUMENTO PARA CUANDO SE CAMBIE LA PAGINA SE PUEDA COMPROBAR DE NUEVO
    let div = document.querySelectorAll(".days div");
    div.forEach(d => {
        if (e.target == d) {
            //* location.href = `${location.origin}/kano/disponibles2.php?fecha=${d.id}`; //* PARA LA PÁGINA WEB
            location.href = `disponibles2.php?fecha=${d.id}`; //* PARA LA PÁGINA WEB EN LOCAL
        }
    });
});
