<?php


class Cliente extends Controllers
{

    public function __construct()
    {
        parent::__construct();
    }

    public function cliente($idCliente)
    {
        echo "Cliente " . $idCliente;
    }

    public function registro($params)
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];

            if ($method == 'POST') {
                $datos = json_decode(file_get_contents('php://input'), true);
                // dep($datos);

                if (empty($datos["identificacion"])) {
                    jsonResponse(array("status" => false, "msg" => "La identificación es requerida"), 200);
                    die();
                }
                if (empty($datos["direccion"])) {
                    jsonResponse(array("status" => false, "msg" => "La direccion es requerida"), 200);
                    die();
                }
                if (!testString($datos["nombres"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo nombres"), 200);
                    die();
                }
                if (!testString($datos["apellidos"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo apellidos"), 200);
                    die();
                }
                if (!testEntero($datos["telefono"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo Telefono"), 200);
                    die();
                }
                if (!testEmail($datos["email"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo email"), 200);
                    die();
                }

                $datos["nombres"] = ucwords(strtolower($datos["nombres"]));
                $datos["apellidos"] = ucwords(strtolower($datos["apellidos"]));
                $datos["email"] = strtolower($datos["email"]);
                $datos["nit"] = !empty($datos["nit"]) ? strClean($datos["nit"]) : "";
                $datos["nombrefiscal"] = !empty($datos["nombrefiscal"]) ? strClean($datos["nombrefiscal"]) : "";
                $datos["direccionfiscal"] = !empty($datos["direccionfiscal"]) ? strClean($datos["direccionfiscal"]) : "";

                $request = $this->model->setCliente($datos);

                if ($request > 0) {
                    $datos["idCliente"] = $request;
                    $response = array('status' => true, 'msg' => "Datos guardados correctamente", "data" => $datos);
                    jsonResponse($response, 200);
                } else {
                    $response = array('status' => false, 'msg' => "Email o identificacion ya existe!");
                    jsonResponse($response, 200);
                }
            } else {
                $response = array('status' => false, 'msg' => "Error con la solicitud");
                jsonResponse($response, 400);
            }
        } catch (\Exception $e) {
            echo "Error con el proceso: " . $e->getMessage();
        }

        die();
    }

    public function clientes($params)
    {
        echo "Todos Cliente";
    }

    public function actualizar($idCliente)
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];


            if ($method == "PUT") {
                $datos = json_decode(file_get_contents('php://input'), true);

                if (empty($idCliente) || !is_numeric($idCliente)) {
                    $response = array('status' => false, 'msg' => "Error en los parametros");
                    jsonResponse($response, 200);
                    die();
                }

                if (empty($datos["identificacion"])) {
                    jsonResponse(array("status" => false, "msg" => "La identificación es requerida"), 200);
                    die();
                }
                if (empty($datos["direccion"])) {
                    jsonResponse(array("status" => false, "msg" => "La direccion es requerida"), 200);
                    die();
                }
                if (!testString($datos["nombres"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo nombres"), 200);
                    die();
                }
                if (!testString($datos["apellidos"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo apellidos"), 200);
                    die();
                }
                if (!testEntero($datos["telefono"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo Telefono"), 200);
                    die();
                }
                if (!testEmail($datos["email"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo email"), 200);
                    die();
                }

                $datos["nombres"] = ucwords(strtolower($datos["nombres"]));
                $datos["apellidos"] = ucwords(strtolower($datos["apellidos"]));
                $datos["email"] = strtolower($datos["email"]);
                $datos["nit"] = !empty($datos["nit"]) ? strClean($datos["nit"]) : "";
                $datos["nombrefiscal"] = !empty($datos["nombrefiscal"]) ? strClean($datos["nombrefiscal"]) : "";
                $datos["direccionfiscal"] = !empty($datos["direccionfiscal"]) ? strClean($datos["direccionfiscal"]) : "";

                $request = $this->model->putCliente($idCliente, $datos);

                if ($request) {
                    $datos["id"] = $idCliente;
                    $response = array('status' => true, 'msg' => "Datos actualizados correctamente!", "data" => $datos);
                    jsonResponse($response, 200);
                } else {
                    $response = array('status' => false, 'msg' => "La identificación o email ya existen");
                    jsonResponse($response, 200);
                }
            } else {
                $response = array('status' => false, 'msg' => "Error con la solicitud {$method}");
                jsonResponse($response, 400);
            }
        } catch (Exception $e) {
            echo "Error con el proceso: " . $e->getMessage();
        }
        die();
    }

    public function eliminar($idCliente)
    {
        echo "eliminar Cliente";
    }
}
