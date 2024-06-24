<?php

class UsuarioModel extends Mysql
{

    private $intId;
    private $strNombres;
    private $strApellidos;
    private $strEmail;
    private $strPassword;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuario($id)
    {
        $this->intId = $id;
        $sql = "SELECT * FROM usuarios WHERE id=:id  and status=1";
        $arrData = array(
            "id" => $this->intId
        );
        $request = $this->select($sql, $arrData);
        return $request;
    }

    public function getUsuarios()
    {
        $sql = "SELECT * FROM usuarios WHERE  status=1 order by id desc";
        $request = $this->select_all($sql);
        return $request;
    }

    public function setUser($datos)
    {
        $this->strNombres = $datos["nombre"];
        $this->strApellidos = $datos["apellido"];
        $this->strEmail = $datos["email"];
        $this->strPassword = $datos["password"];

        $sql = "SELECT email FROM usuarios  WHERE email='$this->strEmail' AND status !=0 ";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sqlInsert = "INSERT INTO usuarios (nombre, apellido, email, password) VALUES (:nom, :ape, :email, :pass)";
            $arrData = array(
                ":nom" => $this->strNombres,
                ":ape" => $this->strApellidos,
                ":email" => $this->strEmail,
                ":pass" => $this->strPassword
            );
            $reqInsert = $this->insert($sqlInsert, $arrData);
            return $reqInsert;
        } else {
            return false;
        }

        dep(get_object_vars($this));
    }

    public function updateUser($datos)
    {
        $this->intId = $datos["id"];
        $this->strNombres = $datos["nombre"];
        $this->strApellidos = $datos["apellido"];
        $this->strEmail = $datos["email"];
        $this->strPassword = $datos["password"];

        $sql = "SELECT email FROM usuarios  WHERE email != '$this->strEmail' AND status !=0 ";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sqlUpdate = "UPDATE usuarios SET nombre=:nom, apellido=:ape, email=:email";
            if ($this->strPassword != "") {
                $sqlUpdate .= ", password=:pass ";
            }
            $sqlUpdate .= " WHERE id=:id ";
            $arrData = array(
                ":nom" => $this->strNombres,
                ":ape" => $this->strApellidos,
                ":email" => $this->strEmail,
                ":pass" => $this->strPassword,
                ":id" => $this->intId
            );
            // dep($sqlUpdate);
            // dep($arrData);
            $reqUpdate = $this->update($sqlUpdate, $arrData);
            return $reqUpdate;
        } else {
            return false;
        }

        dep(get_object_vars($this));
    }

    public function deleteUsuario($id)
    {
        $this->intId = $id;
        // $sql = "DELETE  FROM usuarios WHERE id=:id ";
        $sql = "UPDATE usuarios SET estado=0 WHERE id=:id ";
        $arrData = array(
            ":id" => $this->intId
        );
        $reqUpdate = $this->update($sql, $arrData);
        return $reqUpdate;
    }

    public function loginUser(string $email, string $password)
    {
        $this->strEmail = $email;
        $this->strPassword = $password;
        $sql = "SELECT id, status, email, password FROM usuarios where email= BINARY :email and password= BINARY :pass and status=1 ";
        $arrData = array(
            ":email" => $this->strEmail,
            ":pass" => $this->strPassword
        );
        // dep($arrData);
        $reqest = $this->select($sql, $arrData);
        return $reqest;
    }
}
