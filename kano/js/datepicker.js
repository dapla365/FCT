/* DESHABILITAR FINES DE SEMANA */

$(function () {
    $('#calendar').datepicker({
        beforeShowDay: $.datepicker.noWeekends,
        minDate: 0
    });
});


/* DESHABILITAR DIAS CONCRETOS */
/* 
// Obtener fecha actual
let fecha = new Date();
// Agregar 3 días
fecha.setDate(fecha.getDate() + 3);
// Obtener cadena en formato yyyy-mm-dd, eliminando zona y hora
let fechaMin = fecha.toISOString().split('T')[0];
// Asignar valor mínimo
document.querySelector('#fechaReserva').min = fechaMin;


<div class="form-group">
      <label class="control-label col-md-1 col-sm-3 col-xs-12">FECHA<span class="required">*</span>
      </label>
      <div class="col-md-4 col-sm-4 col-xs-3">
      <input type="date" id="fechaReserva" onkeydown="return false" name="created_at"><br>
</div>
*/