/* DESHABILITAR FINES DE SEMANA */

 $(function() {
    $('#calendar').datepicker({ 
        beforeShowDay: $.datepicker.noWeekends,
        minDate: 0
    });
});