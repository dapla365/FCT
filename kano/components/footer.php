<footer></footer>
<?php include "../cita-peluquero.php"; ?>

<script>
    function myFunction() {
        var x = document.getElementById("navbar");
        if (x.className === "navbar") {
            x.className += " responsive";
        } else {
            x.className = "navbar";
        }
    }
    $(document).ready(function() {
        $('#calendar').change(function() {
            var valorSelect1 = $(this).val();
            $.ajax({
                url: 'components/horas_disponibles_peluquero.php',
                method: 'POST',
                data: {
                    opcion: valorSelect1,
                    peluquero: <?php
                                if ($peluquero == "" || $peluquero == NULL) {
                                    echo "a";
                                } else {
                                    echo "$peluquero";
                                }
                                ?>
                },
                success: function(data) {
                    $('#hours').html(data);
                    $('#hours').prop('disabled', false);
                }
            });
        });
        $('#calendario').change(function() {
            var valorSelect1 = $(this).val();
            $.ajax({
                url: 'components/horas_disponibles.php',
                method: 'POST',
                data: {
                    opcion: valorSelect1
                },
                success: function(data) {
                    $('#horas').html(data);
                    $('#horas').prop('disabled', false);
                }
            });
        });
    });
</script>
</body>

</html>