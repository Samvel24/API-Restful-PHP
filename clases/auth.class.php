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
                    if ($datos[0]['Estado'] == "Activo") {
                        // crear el token
                        $token = $this->insertarToken($datos[0]['UsuarioId']);

                        /* Si el valor devuelto por el método insertarToken() no es cero o 
                        no es idéntico a cero (mismo tipo) entonces devolvemos el token 
                        generado.Este programa funciona correctamente al usar el operador 
                        No idéntico (!==)
                        */
                        if($token !== 0) {
                            /* si se guardo el token entonces establecemos la llave 'result'
                            de la respuesta (response) con el valor del token
                            */
                            $result = $respuesta->setKeyResultInResponse("token", $token);
                            return $result;
                        }
                        else {
                            // error al guardar
                            return $respuesta->error_500("Error interno, no se ha podido guardar el token");
                        }
                    } 
                    else {
                        // el usuario está inactivo
                        return $respuesta->error_200("El usuario esta inactivo");    
                    }
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

    private function insertarToken($usuarioId) {
        $val = true;
        /*
        Con openssl_random_pseudo_bytes() generamos una cadena de bytes pseudo-aleatoria, con el 
        número de bytes determinado por el parámetro length (16 en este caso) y con  bin2hex()
        convertimos esos datos binarios en su representación hexadecimal
        */
        $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
        $fecha = date("Y-m-d H:i");
        $estado = "Activo";
        $consulta = "INSERT INTO usuarios_token (UsuarioId, Token, Estado, Fecha)
        VALUES ('$usuarioId', '$token', '$estado', '$fecha')";
        
        $filas = parent::filasAfectadas($consulta);
        if($filas >= 1) {
            return $token;
        }
        else {
            return 0;
        }
    }
}

?>