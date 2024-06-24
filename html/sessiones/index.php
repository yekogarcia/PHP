<?php

require_once 'vendor/autoload.php';
require_once 'src/Database.php';
require_once 'src/Usuario.php';

use Firebase\JWT\JWT;


$db = new Database();
// $db = $database->getConnection();
// $res = $db->executeQuery("select * from  users");
// var_dump($res);
$usuario = new Usuario($db);
$usuario->registrarUsuario("Ender", "3123365967", "enderg", "enderg");

// Ruta para registrar un usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['PATH_INFO'] === '/registro') {
    $data = json_decode(file_get_contents('php://input'));

    // Validar datos de entrada
    if (!empty($data->nombreUsuario) && !empty($data->contrasena)) {
        $nombreUsuario = $data->nombreUsuario;
        $contrasena = $data->contrasena;

        // Registrar el usuario en la base de datos

    }
}
echo "Hola";
