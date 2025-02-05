<?php

class Conexion
{

    private $conect;

    public function __construct()
    {
        if (CONNECTION) {
            try {
                $connectionString = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                $this->conect = new PDO($connectionString, DB_USER, DB_PASSWORD);
                $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $this->conect = "Error de conexión";
                echo "ERROR: " . $e->getMessage();
            }
        }
    }

    public function connect()
    {
        return $this->conect;
    }
}
