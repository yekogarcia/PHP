<?php


class ClienteModel extends Mysql
{
    private $intIdCliente;
    private $strIdentificacion;
    private $strNombres;
    private $strApellidos;
    private $intTelefono;
    private $strEmail;
    private $strDireccion;
    private $strNit;
    private $strNomFiscal;
    private $strDirFiscal;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function setCliente($datos)
    {
        $this->strIdentificacion = $datos["identificacion"];
        $this->strNombres = $datos["nombres"];
        $this->strApellidos = $datos["apellidos"];
        $this->intTelefono = $datos["telefono"];
        $this->strEmail = $datos["email"];
        $this->strDireccion = $datos["direccion"];
        $this->strNit = $datos["nit"];
        $this->strNomFiscal = $datos["nombrefiscal"];
        $this->strDirFiscal = $datos["direccionfiscal"];


        $sql = "SELECT identificacion, email FROM cliente WHERE (email=:email or identificacion =:ident) and status=:estado";
        $arrParams = array(
            ":email" => $this->strEmail,
            ":ident" => $this->strIdentificacion,
            ":estado" => 1
        );
        $request = $this->select($sql, $arrParams);
        if (!empty($request)) {
            return false;
        }

        $sqlInsert = "INSERT INTO cliente (identificacion,nombres,apellidos,telefono,email,direccion,nit,nombrefiscal,direccionfiscal,status) 
        VALUES (:ident,:nom,:ape,:tel,:email,:dir,:nit,:nomfiscal,:dirfiscal,:status)";
        $arrInsert = array(
            ":ident" => $this->strIdentificacion,
            ":nom" => $this->strNombres,
            ":ape" => $this->strApellidos,
            ":tel" => $this->intTelefono,
            ":email" => $this->strEmail,
            ":dir" => $this->strDireccion,
            ":nit" => $this->strNit,
            ":nomfiscal" => $this->strNomFiscal,
            ":dirfiscal" => $this->strDirFiscal,
            ":status" => 1
        );

        // dep($reqInsert);
        // dep($arrInsert);
        $reqInsert = $this->insert($sqlInsert, $arrInsert);
        die();
        // dep(get_object_vars($this));

        return $reqInsert;
    }

    public function putCliente($IdCliente, $datos)
    {
        $this->intIdCliente = $IdCliente;
        $this->strIdentificacion = $datos["identificacion"];
        $this->strNombres = $datos["nombres"];
        $this->strApellidos = $datos["apellidos"];
        $this->intTelefono = $datos["telefono"];
        $this->strEmail = $datos["email"];
        $this->strDireccion = $datos["direccion"];
        $this->strNit = $datos["nit"];
        $this->strNomFiscal = $datos["nombrefiscal"];
        $this->strDirFiscal = $datos["direccionfiscal"];

        $sql = "SELECT identificacion,email FROM cliente WHERE id !=:id and (email=:email or identificacion=:ident) and status=1";
        $arrData = array(
            ":email" => $this->strEmail,
            ":ident" => $this->strIdentificacion,
            ":id" => $this->intIdCliente
        );

        $request_client = $this->select($sql, $arrData);

        if (empty($request_client)) {

            $sql = "UPDATE cliente  SET identificacion=:ident, nombres=:nom, apellidos=:ape, telefono=:tel, email=:email, direccion=:dir,
    nit=:nit, nombrefiscal=:nomfiscal, direccionfiscal=:dirfiscal,status=:status WHERE id=:id ";

            $arrUpdate = array(
                ":id" => $this->intIdCliente,
                ":ident" => $this->strIdentificacion,
                ":nom" => $this->strNombres,
                ":ape" => $this->strApellidos,
                ":tel" => $this->intTelefono,
                ":email" => $this->strEmail,
                ":dir" => $this->strDireccion,
                ":nit" => $this->strNit,
                ":nomfiscal" => $this->strNomFiscal,
                ":dirfiscal" => $this->strDirFiscal,
                ":status" => 1
            );

            $request = $this->update($sql, $arrUpdate);
            return  $request;
        } else {
            return false;
        }

        dep($request_client);
    }
}
