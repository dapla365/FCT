<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<div class="centrar">
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
</div>
<?php include "components/footer.php" ?>