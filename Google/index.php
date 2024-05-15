<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $credential = $_POST['credential'];

    // Verificar el token con Google
    $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $credential;
    $response = file_get_contents($url);
    $payload = json_decode($response, true);

    if (isset($payload['sub'])) {
        $userid = $payload['sub'];
        $email = $payload['email'];
        $given_name = $payload['given_name'];
        $family_name = $payload['family_name'];
        $picture = $payload['picture'];
        // Aquí puedes manejar el inicio de sesión del usuario, por ejemplo, crear una sesión

        echo $userid ." - " . $email." - ". $given_name." - ". $family_name." - " . $picture;
       // echo json_encode(['success' => true, 'userid' => $userid]);
    } else {
        // Token no válido
        echo json_encode(['success' => false, 'message' => 'Token invalido']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metodo de solicitud no valido']);
}

