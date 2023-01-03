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
            // parent sirve para acceder a propiedades y métodos de la clase de la que estamos heredando
            $password = parent::encriptar($password);
            $datos = $this->obtenerDatosUsuario($usuario);

            if ($datos != 0) {
                // verificar si la contraseña ingresada es igual a la de la base de datos
                if($password == $datos[0]['Password']) {

                }
                else {
                    return $respuesta->error_200("El password es ivalido");
                }
            } 
            else {
                // no existe el usuario
                return $respuesta->error_200("El usuario $usuario no existe");
            }
        }
    }

    private function obtenerDatosUsuario($correo) {
        $consulta = "SELECT UsuarioId, Password, Estado FROM usuarios WHERE Usuario = '$correo'";
        // parent sirve para acceder a propiedades y métodos de la clase de la que estamos heredando
        $datos = parent::obtenerDatos($consulta);

        // verificamos si no es null el campo 'UsuarioId' en el arrelgo $datos
        if (isset($datos[0]['UsuarioId'])) {
            return $datos;
        }
        else {
            return 0;
        }
    }
}

?>