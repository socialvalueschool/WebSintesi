<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$password = "bola1985";
$dbname = "socialvalueschool";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "mensaje" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $primer_apellido = trim($_POST['primer_apellido']);
    $segundo_apellido = trim($_POST['segundo_apellido']);
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    $telefono = trim($_POST['telefono']);
    $ciudad = trim($_POST['ciudad']);
    $pais = trim($_POST['pais']);
    $codigo_postal = trim($_POST['codigo_postal']);
    $numero_tarjeta = trim($_POST['numero_tarjeta']);
    $fecha_expiracion = trim($_POST['fecha_expiracion']);
    $codigo_cvv = trim($_POST['codigo_cvv']);
    $correo = trim($_POST['correo']);

    if (empty($nombre) || empty($primer_apellido) || empty($segundo_apellido) || empty($nombre_usuario) || empty($contraseña) ||
        empty($telefono) || empty($ciudad) || empty($pais) || empty($codigo_postal) || empty($numero_tarjeta) ||
        empty($fecha_expiracion) || empty($codigo_cvv) || empty($correo)) {
        
        echo json_encode(["status" => "error", "mensaje" => "Todos los campos son obligatorios."]);
        exit;
    }

    // Validar que el usuario no exista
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? OR correo = ?");
    $stmt->bind_param("ss", $nombre_usuario, $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "exists", "mensaje" => "El usuario ya está registrado.", "redirect" => "/html/login.html"]);
        exit;
    }
    $stmt->close();

    // Insertar usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, primer_apellido, segundo_apellido, nombre_usuario, contraseña, telefono, ciudad, pais, codigo_postal, numero_tarjeta, fecha_expiracion, codigo_cvv, correo) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $nombre, $primer_apellido, $segundo_apellido, $nombre_usuario, $contraseña, $telefono, $ciudad, $pais, $codigo_postal, $numero_tarjeta, $fecha_expiracion, $codigo_cvv, $correo);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "mensaje" => "Registro exitoso", "redirect" => "/html/login.html"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Error al registrar usuario"]);
    }
    $stmt->close();
}
$conn->close();
?>
