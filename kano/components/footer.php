<footer></footer>
<?php include "../cita-peluquero.php"; ?>

<script>
    $(document).ready(function() {
        $('#calendar').change(function() {
            var valorSelect1 = $(this).val();
            $.ajax({
                url: 'components/horas_disponibles_peluquero.php',
                method: 'POST',
                data: {
                    opcion: valorSelect1,
                    peluquero: <?php 
                    if($peluquero == "" || $peluquero == NULL){
                        echo "a";
                    }else{
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