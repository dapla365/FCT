<footer></footer>
<?php include "../cita-peluquero.php"; ?>

<script>
    $(document).ready(function() {
        $('#calendar').change(function() {
            var valorSelect1 = $(this).val();
            $.ajax({
                url: 'components/horas_disponibles.php',
                method: 'POST',
                data: {
                    opcion: valorSelect1,
                    peluquero: <?php echo "$peluquero"; ?>
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