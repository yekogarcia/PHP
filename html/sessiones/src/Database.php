<?php
class Database
{
    // private $host = "localhost";
    // private $db_name = "nombre_base_de_datos";
    // private $username = "nombre_usuario";
    // private $password = "contraseña";

    // public function getConnection()
    // {
    //     try {
    //         $conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
    //         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //         return $conn;
    //     } catch (PDOException $e) {
    //         echo "Error de conexión: " . $e->getMessage();
    //         exit();
    //     }
    // }


    private $db;

    public function __construct()
    {
        $dbFile = __DIR__ . '/db/mydatabse.db';
        error_log($dbFile);
        $this->db = new PDO("sqlite:" . $dbFile);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function executeQuery($query)
    {
        try {
            return $this->db->query($query);
        } catch (\Throwable $th) {
            error_log("ERRORS EXECUTE QUERY: " . $th);
        }
    }

    public function execPrepare($query)
    {
        try {
            // error_log($query);
            $pdo = $this->db->prepare($query);
            $pdo->execute();
            if ($pdo->rowCount() > 0) {
                error_log('Insert exitosa');
            } else {
                error_log('No se pudo realizar la inserción');
            }
        } catch (\Throwable $th) {
            error_log("ERRORS EXECUTE QUERY: " . $th);
        }
    }



    // Métodos para ejecutar consultas, por ejemplo: insert, select, etc.
    // ...
}
