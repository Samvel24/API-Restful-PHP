<?php
require_once 'clases/auth.class.php';
require_once 'clases/respuesta.class.php';

$auth = new Auth();
$repuesta = new Respuesta();

/* Preguntamos al servidor si el método mediante el cual se envía la solicitud 
(REQUEST_METHOD) es el método POST
*/
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    /*
    Sobre la siguiente instrucción:
    Los flujos fueron introducidos como una manera de generalizar operaciones con 
    ficheros, redes, compresión de datos, y otras operaciones que comparten un conjunto 
    común de funciones y usos. En su definición más simple, un flujo es un objeto de 
    tipo recurso que exhibe un comportamiento transmisible.
    Para saber más de esto, ver: https://www.php.net/manual/en/intro.stream.php
    
    php://input es un flujo de solo lectura que le permite leer datos sin procesar del 
    cuerpo de la solicitud.
    Ver: https://www.php.net/manual/en/wrappers.php.php#wrappers.php.input

    De acuerdo con lo anterior, con file_get_contents() se leen los datos del cuerpo de la
    solicitud y los guardamos como una cadena en la variable postBody
    */
    $postBody = file_get_contents("php://input");
    $datosArray = $auth->login($postBody);
    print_r(json_encode($datosArray));
}
else {
    echo "Método no permitido";
}
?>