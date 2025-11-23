<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];
    $hash = password_hash($clave, PASSWORD_DEFAULT);

    $db = conectar();
    $stmt = $db->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
    if ($stmt->execute([$usuario, $hash])) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error al registrar.";
    }
}
?>

<form method="POST">
  <br>
  Usuario: <input type="text" name="usuario" required><br>
  Contraseña: <input type="password" name="clave" required><br>
  <button type="submit">Registrar</button>
</form>