<?php
require_once "conexion/conexion.php";
require_once "respuesta.class.php";

class Paciente extends Conexion
{
    private $table = "pacientes";

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

    public function obtenerPaciente($id) {
        $consulta = "SELECT * FROM " . $this->table . " WHERE PacienteId = '$id'";
        
        // llamamos a la función obtenerDatos() de la clase Conexion (clase padre)
        return parent::obtenerDatos($consulta);
    }
}

?>