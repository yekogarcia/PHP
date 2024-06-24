<?php

class OauthjwtModel extends Mysql
{
    private $strNombre;
    private $strApellido;
    private $strEmail;
    private $strPassword;

    public function __construct()
    {
        parent::__construct();
    }

    public  function setCliente($datos)
    {
        $this->strNombre = $datos["nombre"];
        $this->strApellido = $datos["apellido"];
        $this->strEmail = $datos["email"];
        $this->strPassword = $datos["password"];

        dep(get_object_vars($datos));
    }
}
