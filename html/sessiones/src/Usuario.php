<?php

class Usuario
{
    private $conn;

    public function __construct($db)
    {
        var_dump($db);
        $this->conn = $db;
    }

    public function registrarUsuario(string $name, string $cell, string $user, string $pass)
    {
        // Lógica para registrar un usuario en la base de datos
        // ...
        $this->conn->execPrepare("insert into users (name,cell_phone,user,password) values ('{$name}', '{$cell}','{$user}', '{$pass}' )");
        $res = $this->conn->executeQuery("select * from users");
        var_dump($res->fetchAll(PDO::FETCH_ASSOC));
    }

    public function autenticarUsuario($nombreUsuario, $contrasena)
    {
        // Lógica para autenticar al usuario
        // ...
    }
}
