<?php


class Mysql extends Conexion
{
    private $conexion;
    private $strquery;
    private $arrValues;


    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

    public function insert(string $query, array $arrValues)
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;

            $insert = $this->conexion->prepare($this->strquery);
            $arrData = array($this->arrValues);
            $resInsert = $insert->execute($arrData);
            $idInsert = $this->conexion->lastInsertId();
            $insert->closeCursor();
            return $idInsert;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function select_all(string $query)
    {
        try {
            $this->strquery  = $query;

            $execute = $this->conexion->query($this->strquery);
            $request = $execute->fetchall(PDO::FETCH_ASSOC); //ARRAY
            //$request = $execute->fetchall(PDO::FETCH_CLASS); //OBJETOS
            $execute->closeCursor();
            return $request;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function select(string $query, array $arrValues)
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;

            $query = $this->conexion->prepare($this->strquery);
            $query->execute($this->arrValues);
            $request = $query->fetch(PDO::FETCH_ASSOC); //ARRAY
            $query->closeCursor();
            return $request;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function update(string $query, array $arrValues)
    {

        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;

            $update = $this->conexion->prepare($this->strquery);
            $arrData = array($this->arrValues);
            $resUdpate = $update->execute($arrData);
            $update->closeCursor();
            return $resUdpate;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function delete(string $query, array $arrValues)
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;

            $delete = $this->conexion->prepare($this->strquery);
            $del = $delete->execute($this->arrValues);
            return $del;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
