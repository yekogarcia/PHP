<?php


class Usuario extends Controllers
{

    public function __construct()
    {
        parent::__construct();
    }

    public function usuario($id)
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];
            if ($method == 'GET') {
                if (empty($id) or !is_numeric($id)) {
                    jsonResponse(array("status" => false, "msg" => "Error en los parametros"), 400);
                    die();
                }
                $arrUsuario = $this->model->getUsuario($id);

                if (empty($arrUsuario)) {
                    jsonResponse(array("status" => false, "msg" => "Registro no encontrado"), 200);
                } else {
                    jsonResponse(array("status" => true, "msg" => "Registros encontrados", "data" => $arrUsuario), 200);
                }
            } else {
                jsonResponse(array("status" => false, "msg" => "Error en la solicitud"), 400);
            }
            die();
        } catch (Exception $e) {
            echo "Error con el proceso: " . $e->getMessage();
        }
        die();
    }

    public function usuarios()
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];
            if ($method == 'GET') {

                $arrUsuario = $this->model->getUsuarios();
                if (empty($arrUsuario)) {
                    jsonResponse(array("status" => false, "msg" => "Registro no encontrado"), 200);
                } else {
                    jsonResponse(array("status" => true, "msg" => "Registros encontrados", "data" => $arrUsuario), 200);
                }
            } else {
                jsonResponse(array("status" => false, "msg" => "Error en la solicitud"), 400);
            }
            die();
        } catch (Exception $e) {
            echo "Error con el proceso: " . $e->getMessage();
        }
        die();
    }


    public function registro()
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

                $request = $this->model->setUser($datos);

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
    public function actualizar($idUsuario)
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];

            if ($method == 'PUT') {
                $datos = json_decode(file_get_contents('php://input'), true);
                // dep($datos);

                if (empty($idUsuario) or !is_numeric($idUsuario)) {
                    jsonResponse(array("status" => false, "msg" => "Error en los parametros"), 400);
                    die();
                }
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

                $datos["id"] = $idUsuario;
                $datos["nombre"] = ucwords(strtolower($datos["nombre"]));
                $datos["apellido"] = ucwords(strtolower($datos["apellido"]));
                $datos["email"] = strtolower($datos["email"]);
                $datos["password"] = !empty($datos["password"]) ? hash("SHA256", $datos["password"]) : "";

                $buscar_usuario = $this->model->getUsuario($idUsuario);
                if (empty($buscar_usuario)) {
                    $response = array('status' => true, 'msg' => "El usuario no existe");
                    jsonResponse($response, 200);
                    die();
                }

                $request = $this->model->updateUser($datos);

                if ($request > 0) {
                    $response = array('status' => true, 'msg' => "Datos actualizados correctamente", "data" => $datos);
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

    public function eliminar($id)
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];

            if ($method == 'DELETE') {

                if (empty($id) or !is_numeric($id)) {
                    jsonResponse(array("status" => false, "msg" => "Error en los parametros"), 400);
                    die();
                }
                $buscar_usuario = $this->model->getUsuario($id);
                if (empty($buscar_usuario)) {
                    jsonResponse(array("status" => false, "msg" => "El usuario no existe o ya fue eliminado"), 400);
                    die();
                }

                $request = $this->model->deleteUsuario($id);
                if ($request) {
                    jsonResponse(array("status" => true, "msg" => "Registro eliminado"), 200);
                } else {
                    jsonResponse(array("status" => false, "msg" => "No es posible elimiar el usuario"), 200);
                }
                die();
            }
            $response = array('status' => false, 'msg' => "Error con la solicitud");
            jsonResponse($response, 400);
        } catch (\Exception $e) {
            echo "Error con el proceso: " . $e->getMessage();
        }
        die();
    }

    public function login()
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];

            if ($method == 'POST') {
                $datos = json_decode(file_get_contents('php://input'), true);
                if (empty($datos["email"]) || empty($datos["email"])) {
                    $response = array('status' => false, 'msg' => "Error en los datos");
                    jsonResponse($response, 200);
                    die();
                }
                $strEmail = strClean($datos["email"]);
                $strPassword = hash("SHA256", $datos["password"]);
                $request = $this->model->loginUser($strEmail, $strPassword);
                if (empty($request)) {
                    $response = array('status' => false, 'msg' => "Usuario o contraseña incorrecta");
                    jsonResponse($response, 200);
                    die();
                }
                $response = array('status' => true, 'msg' => "Ingreso correcto", "data" => $request);
                jsonResponse($response, 200);
            } else {
                $response = array('status' => false, 'msg' => "Error con la solicitud");
                jsonResponse($response, 400);
            }
        } catch (Exception $e) {
            echo "Error con el proceso: " . $e->getMessage();
        }
        die();
    }
}
