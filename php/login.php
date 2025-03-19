<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "bola1985";
$database = "socialvalueschool";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "mensaje" => "Error en la conexión con la base de datos."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "mensaje" => "Todos los campos son obligatorios."]);
        exit;
    }

    // Se obtiene id, contraseña, nombre, ciudad, país y teléfono
    $stmt = $conn->prepare("SELECT id, contraseña, nombre, ciudad, pais, telefono FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $hashedPassword, $nombre, $ciudad, $pais, $telefono);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // Guardamos los datos en la sesión
            $_SESSION["user_id"] = $userId;
            $_SESSION["email"] = $email;
            $_SESSION["nombre_usuario"] = $nombre;
            $_SESSION["ciudad"] = $ciudad;
            $_SESSION["pais"] = $pais;
            $_SESSION["telefono"] = $telefono;

            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => "Contraseña incorrecta."]);
        }
    } else {
        echo json_encode(["status" => "error", "mensaje" => "El usuario no existe."]);
    }

    $stmt->close();
    $conn->close();
}
?>

