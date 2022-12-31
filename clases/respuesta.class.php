<?php
class Respuesta 
{
    private $response = [
        "status" => 'OK',
        "result" => array()
    ];

    /* 
    El código de estado 405 indica que el servidor conoce el método HTTP de solicitud, 
    pero se ha deshabilitado y no se puede usar para ese recurso.
    */
    public function error_405() {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Metodo no permitido"
        );

        return $this->response;
    }

    /*
    El código 200 indica que la solicitud se ha realizado correctamente
    */
    public function error_200($mensaje = "Datos incorrectos") {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $mensaje
        );

        return $this->response;
    }

    /*
    El códigop 400 indica que el servidor no pudo entender la solicitud debido a una 
    sintaxis incorrecta. El cliente NO DEBE repetir la solicitud sin modificaciones
    */
    public function error_400() {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos enviados incompletos o con formato incorrecto"
        );

        return $this->response;
    }
}
?>