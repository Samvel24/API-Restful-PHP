<?php

class Conexion 
{
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    function __construct() {
        $listaDatos = $this->datosConexion();

        /*
        Recorremos el arreglo $listaDatos, en cada iteración el valor del elemento actual se 
        asigna a $value y la clave del elemento actual se asigna a $key
        En este caso, $value es otro arreglo, por tanto se debe usar $value['key'] para
        acceder a cada elemento (valor) de este arreglo, los elementos son 'localhost', 'root', 
        '', 'apirest' y '3306'.

        Para ver lo anterior mas graficamente se puede hacer:
        foreach($listaDatos as $key => $value) {
            foreach($value as $value2) {
                echo "Elemento " . $i . ": " .  $value2 . "<br>";
                $i++;
        }
    }

        */
        foreach($listaDatos as $key => $value) {
            $this->server = $value['server']; // aquel elemento del arreglo cuya clave sea 'server' se asigna al atributo $server
            $this->user = $value['user']; // aquel elemento del arreglo cuya clave sea 'user' se asigna al atributo $user
            $this->password = $value['password']; // \\ \\ 'password' \\ \\ $password
            $this->database = $value['database']; // \\ \\ 'database' \\ \\ $database
            $this->port = $value['port']; // \\ \\ 'port' \\ \\ $port
        }

        /* Para saber más sobre el constructor de la clase mysqli ver: 
        https://www.php.net/manual/es/mysqli.construct.php
        */
        $this->conexion = new mysqli($this->server, $this->user, $this->password, 
                                    $this->database, $this->port);
        if($this->conexion->connect_errno) {
            echo "Algo va mal con la conexión";
            die(); // die() termina el script actual
        }
    }

    private function datosConexion() {
        /* Con dirname() devolvemos la ruta de un directorio, en este caso, la ruta
        del directorio actual; la constante __FILE__ contiene una cadena de caracteres
        con el directorio actual
        */
        $direccion = dirname(__FILE__);
        /*
        Con file_get_contents() se lee un archivo y devuelve como resultado un cadena
        que contiene los datos leídos, en este caso los datos leídos del archivo config
        */
        $jsonData = file_get_contents($direccion . "/" ."config");
        /* Con json_decode() convertimos un string codificado en JSON a una variable de PHP
        Además, se usa true para convertir los datos json en un array asociativo
        */
        return json_decode($jsonData, true);
    }
}

?>