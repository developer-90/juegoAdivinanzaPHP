<?php
session_start();

// Inicializar el juego si no se ha hecho antes
if (!isset($_SESSION['numero_secreto'])) {
    $_SESSION['numero_secreto'] = rand(1, 100); // Número aleatorio entre 1 y 100
    $_SESSION['intentos'] = 0;
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la respuesta del usuario
    $respuesta = $_POST['respuesta'];

    // Incrementar el número de intentos
    $_SESSION['intentos']++;

    // Comprobar la respuesta
    if ($respuesta == $_SESSION['numero_secreto']) {
        $mensaje = "¡Felicidades! Has adivinado el número en " . $_SESSION['intentos'] . " intentos.";
        // Reiniciar el juego
        unset($_SESSION['numero_secreto']);
        unset($_SESSION['intentos']);
    } elseif ($respuesta < $_SESSION['numero_secreto']) {
        $mensaje = "La respuesta es demasiado baja. Intenta de nuevo.";
    } else {
        $mensaje = "La respuesta es demasiado alta. Intenta de nuevo.";
    }
}

// HTML de la página
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Adivinanzas</title>
</head>
<body>
    <h1>Juego de Adivinanzas</h1>

    <?php
    if (isset($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>

    <form action="juego.php" method="post">
        <label for="respuesta">Ingresa tu respuesta (entre 1 y 100):</label>
        <input type="number" name="respuesta" min="1" max="100" required>
        <input type="submit" value="Adivinar">
    </form>

    <?php
    if (isset($_SESSION['intentos'])) {
        echo "<p>Intentos realizados: {$_SESSION['intentos']}</p>";
    }
    ?>
</body>
</html>
