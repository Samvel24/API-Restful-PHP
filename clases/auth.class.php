<?php
require_once 'conexion/conexion.php';
require_once 'respuesta.class.php';

class Auth extends Conexion
{
    public function login($json) {
        $respuesta = new Respuesta();

        // $datos es un array asociativo (segundo argumento = true) devuelto por json_decode()
        $datos = json_decode($json, true);

        // si no existe el campo usuario o no existe el campo password 
        if (!isset($datos['usuario']) || !isset($datos['password'])) {
            // error en los campos
            return $respuesta->error_400();
        }
        else {
            // sin error en los campos
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $datos = $this->obtenerDatosUsuario($usuario);

            if ($datos != 0) {
                // si existe el usuario
                
            } else {
                // no existe el usuario
                return $respuesta->error_200("El usuario $usuario no existe");
            }
        }
    }

    private function obtenerDatosUsuario($correo) {
        $consulta = "SELECT UsuarioId, Password, Estado FROM usuarios WHERE Usuario = '$correo'";
        // parent sirve para acceder a propiedades y métodos de la clase de la que estamos heredando
        $datos = parent::obtenerDatos($consulta);

        if (isset($datos[0]['UsuarioId'])) { // si existe el campo 'UsuarioId' en el arrelgo $datos
            return $datos;
        }
        else {
            return 0;
        }
    }
}

?>