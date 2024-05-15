<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión con Google</title>
</head>
<body>
    <div id="g_id_onload"
         data-client_id="660615750081-krtpr2m9e302c0rqdphef0ccvjn5uu25.apps.googleusercontent.com"
         data-login_uri="https://dapla.thsite.top/Google/"
         data-auto_prompt="false">
    </div>
    <div class="g_id_signin"
         data-type="standard"
         data-shape="rectangular"
         data-theme="outline"
         data-text="signin_with"
         data-size="large"
         data-locale="es_ES">
    </div>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function handleCredentialResponse(response) {
            console.log("Encoded JWT ID token: " + response.credential);
            // Enviar el token al servidor
            fetch('https://dapla.thsite.top/Google/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'credential=' + encodeURIComponent(response.credential)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                // Manejar el éxito del inicio de sesión
            })
            .catch((error) => {
                console.error('Error:', error);
                // Manejar el error del inicio de sesión
            });
        }

        window.onload = function() {
            google.accounts.id.initialize({
                client_id: '660615750081-krtpr2m9e302c0rqdphef0ccvjn5uu25.apps.googleusercontent.com',
                callback: handleCredentialResponse
            });
            google.accounts.id.renderButton(
                document.getElementById("buttonDiv"),
                { theme: "outline", size: "large" }  // personaliza el botón
            );
            google.accounts.id.prompt(); // para mostrar el diálogo de inicio de sesión automáticamente
        };
    </script>
</body>
</html>
