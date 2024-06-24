<?php


class Oauthjwt extends Controllers
{

    public function __construct()
    {
        parent::__construct();
    }

    public function oauthjwt($params)
    {
        $data["page_tag"] = "Home";
        $data["page_title"] = "Home Home";
        $data["page_name"] = "home";

        $this->views->getView($this, "home", $data);
    }

    public function RegistroCliente($params)
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];

            if ($method == 'POST') {
                $datos = json_decode(file_get_contents('php://input'), true);
                // dep($datos);

                if (!testString($datos["nombre"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo nombres"), 200);
                    die();
                }
                if (!testString($datos["apellido"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo apellidos"), 200);
                    die();
                }
                if (!testEmail($datos["email"])) {
                    jsonResponse(array("status" => false, "msg" => "Error en el campo email"), 200);
                    die();
                }

                $datos["nombre"] = ucwords(strtolower($datos["nombre"]));
                $datos["apellido"] = ucwords(strtolower($datos["apellido"]));
                $datos["email"] = strtolower($datos["email"]);
                $datos["password"] = hash("SHA256", $datos["password"]);

                $request = $this->model->setCliente($datos);

                if ($request > 0) {
                    $datos["id"] = $request;
                    $response = array('status' => true, 'msg' => "Datos guardados correctamente", "data" => $datos);
                    jsonResponse($response, 200);
                } else {
                    $response = array('status' => false, 'msg' => "El Email de usuario ya existe!");
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
}
