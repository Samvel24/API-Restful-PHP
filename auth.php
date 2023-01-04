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

    // Enviamos los datos del cuerpo de la solicitud al método login() de la clase Auth
    $datosArray = $auth->login($postBody);

    /*
    La función header() envia un encabezado http sin procesar al navegador. Un encabezado
    es información adicional enviada antes del contenido real que se ve en el navegador.
    Estamos enviando un string (Content-Type: application/json) que es el parametro $header 
    que requiere la función, este parametro especifica la información del encabezado enviada
    al navegador.
    En este caso Content-Type es el nombre de un encabezado que especifica el tipo de 
    contenido de la cuerpo de la solicitud y application/json es el valor del encabezado e 
    indica que el formato del cuerpo de la solicitud es JSON.
    La información anterior fue obtenida de:
    •https://www.ibm.com/docs/en/order-management?topic=services-specifying-http-headers
    •Kromann, F., Beginning PHP and MySQL From Novice to Professional, 2018
    */
    header('Content-Type: application/json');

    // si existe un campo llamado 'error_id' en el arreglo devuelto por el método login()
    if (isset($datosArray["result"]["error_id"])) {
        // entonces guardamos esto en la variable $responseCode
        $reponseCode = $datosArray["result"]["error_id"];
        // Con http_response_code() obtenemos/establecemos el código de respuesta HTTP
        http_response_code($reponseCode);
    }
    else {
        /* Si no hay error, entonces el código de respuesta es 200, es decir, que la solicitud 
        se ha realizado correctamente.
        */
        http_response_code(200);
    }
    
    /* 
    Con echo, mostramos en pantalla alguna de las respuestas devueltas por el método login(),
    esto es, $datosArray es lo mismo que el arreglo $response de la clase Respuesta porque
    cada uno de los método de esta clase devuelve el arreglo $response de acuerdo a cada 
    caso.
    */
    echo json_encode($datosArray);
}
else {
    header('Content-Type: application/json');
    $datosArray = $repuesta->error_405();

    echo json_encode($datosArray);
}
?>