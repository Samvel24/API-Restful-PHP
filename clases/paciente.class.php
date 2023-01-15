<?php
require_once "conexion/conexion.php";
require_once "respuesta.class.php";

class Paciente extends Conexion
{
    private $table = "pacientes";
    private $pacienteid = "";
    private $curp = "";
    private $nombre = "";
    private $direccion = "";
    private $codigoPostal = "";
    private $genero = "";
    private $telefono = "";
    private $fechaNacimiento = "0000-00-00"; // año, mes, dia
    private $correo = "";
    private $token = "";
    
    /*
    El token se genera como respuesta del servidor al acceder a la dirección
    http://localhost/api_rest/auth y hacer login con uno de los usuarios de la DB, 
    para esto es necesario proporcionar usuario (correo) y password. Si el inicio de sesión
    fue correcto, entonces el token se debe indicar en el json que se suministra
    en las operaciones POST, PUT Y DELETE. Para esto, el programa primero busca el token
    dentro de la base de datos, si existe, entonces se procede a verificar si se puede 
    ejecutar la respectiva operación REST.
    */

    // GET
    public function listaPacientes($pagina = 1) {
        $inicio = 0;
        $cantidad = 50;

        /* 
        lo siguiente servirá para mostrar '$cantidad' número de pacientes en pantalla
        así como mostrarlos en un rango especificado por el usuario, por ejemplo
        si $cantidad = 50 entonces 
        se pueden mostrar los pacientes del 0 al 50, del 51 al 100, del 101 al 150, etc
        */
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $consulta = "SELECT PacienteId, Nombre, CURP, Telefono, Correo FROM " .  $this->table
        . " limit $inicio, $cantidad";
    
        // llamamos a la función obtenerDatos() de la clase Conexion (clase padre)
        $datos = parent::obtenerDatos($consulta);
        return $datos;
    }

    // GET
    public function obtenerPaciente($id) {
        $consulta = "SELECT * FROM " . $this->table . " WHERE PacienteId = '$id'";
        
        // llamamos a la función obtenerDatos() de la clase Conexion (clase padre)
        return parent::obtenerDatos($consulta);
    }

    // POST
    public function guardarPaciente($cadena) {
        $respuesta = new Respuesta();
        $datos = json_decode($cadena, true);

        // si no existe el campo 'token' en $datos
        if (!isset($datos['token'])) {
            return $respuesta->error_401();
        } 
        else {
           $this->token = $datos['token'];
           $arrayToken = $this->buscarToken();
            
           /* 
           Si el token NO está vacio entonces procedemos a verificar si es posible guardar
           un nuevo paciente
            */
           if (!empty($arrayToken)) {
                 // si no existe alguno de los campos en $datos: nombre, curp o correo
                if(!isset($datos['nombre']) || !isset($datos['curp']) || !isset($datos['correo'])) {
                    // entonces devolvemos el error 400
                    return $respuesta->error_400();
                }
                else {
                    $this->nombre = $datos['nombre'];
                    $this->curp = $datos['curp'];
                    $this->correo = $datos['correo'];
                    
                    if(isset($datos['telefono'])) { $this->telefono = $datos['telefono']; }
                    if(isset($datos['direccion'])) { $this->direccion = $datos['direccion']; }
                    if(isset($datos['codigoPostal'])) { $this->codigoPostal = $datos['codigoPostal']; }
                    if(isset($datos['genero'])) { $this->genero = $datos['genero']; }
                    if(isset($datos['fechaNacimiento'])) { $this->fechaNacimiento = $datos['fechaNacimiento']; }
                    
                    $id = $this->insertarPaciente();
                    
                    if($id > 0){
                        $res = $respuesta->setKeyResultInResponse("pacienteId", $id);
                        return $res;
                    }
                    else {
                        return $respuesta->error_500();
                    }
                }
           }
           else {
                return $respuesta->error_401("El token que envio ha caducado o es inválido");
           }
        }
    }

    private function insertarPaciente(){
        $consulta = "INSERT INTO " . $this->table . " (CURP, Nombre, Direccion, CodigoPostal, Telefono, Genero,
        FechaNacimiento, Correo) values ('" . $this->curp . "','" . $this->nombre . "','" 
        . $this->direccion ."','" . $this->codigoPostal . "','"  . $this->telefono . "','" 
        . $this->genero . "','" . $this->fechaNacimiento . "','" . $this->correo . "')"; 

        $id = parent::idUltimaConsulta($consulta);

        if($id > 0){
            return $id;
        }
        else{
            return 0;
        }
    }

    // PUT
    public function actualizarPaciente($cadena) {
        $respuesta = new Respuesta();
        $datos = json_decode($cadena, true);

        // si no existe el campo 'token' en $datos
        if (!isset($datos['token'])) {
            return $respuesta->error_401();
        } 
        else {
           $this->token = $datos['token'];
           $arrayToken = $this->buscarToken();
            
           /* 
           Si el token NO está vacio entonces procedemos a verificar si es posible actualizar
           al paciente indicado
            */
           if (!empty($arrayToken)) {
                // si no existe el campo pacienteId en $datos:
                if(!isset($datos['pacienteId'])) {
                    // entonces devolvemos el error 400
                    return $respuesta->error_400();
                }
                else {
                    $this->pacienteid = $datos['pacienteId'];
                    if(isset($datos['nombre'])) { $this->nombre = $datos['nombre']; }
                    if(isset($datos['curp'])) { $this->curp = $datos['curp']; }
                    if(isset($datos['correo'])) { $this->correo = $datos['correo']; }
                    if(isset($datos['telefono'])) { $this->telefono = $datos['telefono']; }
                    if(isset($datos['direccion'])) { $this->direccion = $datos['direccion']; }
                    if(isset($datos['codigoPostal'])) { $this->codigoPostal = $datos['codigoPostal']; }
                    if(isset($datos['genero'])) { $this->genero = $datos['genero']; }
                    if(isset($datos['fechaNacimiento'])) { $this->fechaNacimiento = $datos['fechaNacimiento']; }
                    
                    $filas = $this->modificarPaciente();
                    
                    if($filas >= 1){
                        $res = $respuesta->setKeyResultInResponse("pacienteId", $this->pacienteid);
                        return $res;
                    }
                    else {
                        return $respuesta->error_400();
                    }
                }
           }
           else {
                return $respuesta->error_401("El token que envio ha caducado o es inválido");
           }
        }
    }

    private function modificarPaciente(){
        $consulta = "UPDATE " . $this->table . " SET Nombre ='" . $this->nombre . "',Direccion = '" 
        . $this->direccion . "', CURP = '" . $this->curp . "', CodigoPostal = '" . $this->codigoPostal 
        . "', Telefono = '" . $this->telefono . "', Genero = '" . $this->genero 
        . "', FechaNacimiento = '" . $this->fechaNacimiento . "', Correo = '" . $this->correo 
        . "' WHERE PacienteId = '" . $this->pacienteid . "'"; 

        $filas = parent::filasAfectadas($consulta);

        if($filas >= 1){
            return $filas;
        }
        else{
            return 0;
        }
    }

    // DELETE
    public function borrarPaciente($cadena) {
        $respuesta = new Respuesta();
        $datos = json_decode($cadena, true);

        // si no existe el campo 'token' en $datos
        if (!isset($datos['token'])) {
            return $respuesta->error_401();
        } 
        else {
           $this->token = $datos['token'];
           $arrayToken = $this->buscarToken();
           
           /* 
           Si el token NO está vacio entonces procedemos a verificar si es posible borrar
           al paciente indicado
            */
           if (!empty($arrayToken)) {
                // si no existe el campo pacienteId en $datos:
                if(!isset($datos['pacienteId'])) {
                    // entonces devolvemos el error 400
                    return $respuesta->error_400();
                }
                else {
                    $this->pacienteid = $datos['pacienteId'];

                    $filas = $this->eliminarPaciente();

                    if($filas >= 1){
                        $res = $respuesta->setKeyResultInResponse("pacienteId", $this->pacienteid);
                        return $res;
                    }
                    else {
                        return $respuesta->error_500();
                    }
                }
           }
           else {
                return $respuesta->error_401("El token que envio ha caducado o es inválido");
           }
        }        
    }

    private function eliminarPaciente() {
        $consulta = "DELETE FROM " . $this->table . " WHERE PacienteId = '" 
            . $this->pacienteid . "'";
  
        $filas = parent::filasAfectadas($consulta);
        print_r($filas);

        if($filas >= 1){
            
            return $filas;
        }
        else{
            return 0;
        }
    }

    // Método para validar que el usuario esté activo y que el token que se envía sea válido
    private function buscarToken() {
        $consulta = "SELECT  TokenId, UsuarioId, Estado from usuarios_token WHERE Token = '" 
        . $this->token . "' AND Estado = 'Activo'";
        
        $datos = parent::obtenerDatos($consulta);

        // si el arreglo devuelto por el método obtenerDatos() NO está vacio
        if (!empty($datos)) {
            return $datos;
        }
        else {
            return 0;
        }
    }

    private function actualizarToken($tokenid) {
        $fecha = date("Y-m-d H:i");
        $consulta = "UPDATE usuarios_token SET Fecha = '$fecha' WHERE TokenId = '$tokenid' ";
        
        $filas = parent::filasAfectadas($consulta);

        if ($filas >= 1) {
            return $filas;
        }
        else {
            return 0;
        }
    }
}

?>