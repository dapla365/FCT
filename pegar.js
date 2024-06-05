
                            if (copied != null) {
                                let paste = null;
                                div.forEach(d => {
                                    if (d.classList.contains('selected')) {
                                        paste = d.id;
                                    }
                                });
                                if (paste == null) {
                                    msg.innerHTML = "¡No has seleccionado ningún día!";
                                    setTimeout(function() {
                                        msg.innerHTML = '';
                                    }, 2000);
                                } else if (copied != paste) {
                                    $.ajax({
                                        url: 'components/comprobarDiaLibre.php',
                                        method: 'POST',
                                        data: {
                                            type: 'pegar',
                                            fecha: copied, //* FECHA QUE QUIERES COPIAR
                                            paste: paste, //* FECHA EN LA QUE QUIERES PEGAR
                                            peluquero: peluquero
                                        },
                                        success: function(data) {
                                            location.reload();
                                        }
                                    });
                                    msg.innerHTML = "¡Pegado!";
                                    setTimeout(function() {
                                        msg.innerHTML = '';
                                    }, 2000);
                                } else {
                                    msg.innerHTML = "¡No puedes pegar en el mismo dia que has copiado!";
                                    setTimeout(function() {
                                        msg.innerHTML = '';
                                    }, 2000);
                                }
                            }

            