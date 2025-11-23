<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];

    $db = conectar();
    $stmt = $db->prepare("SELECT password FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($clave, $row["password"])) {
        echo "Inicio de sesión correcto.";
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>

<form method="POST">
  Usuario: <input type="text" name="usuario" required><br>
  Contraseña: <input type="password" name="clave" required><br>
  <button type="submit">Ingresar</button>
</form>