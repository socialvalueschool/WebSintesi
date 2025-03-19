<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "mensaje" => "No has iniciado sesión."]);
    exit;
}

echo json_encode([
    "status" => "success",
    "nombre_usuario" => $_SESSION["nombre_usuario"],
    "ciudad" => $_SESSION["ciudad"],
    "pais" => $_SESSION["pais"],
    "telefono" => $_SESSION["telefono"]
]);
?>
