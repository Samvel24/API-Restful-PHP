<?php
require_once 'clases/respuesta.class.php';
require_once 'clases/paciente.class.php';

$respuesta = new Respuesta();
$paciente = new Paciente();

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    /*
    $_GET['string'] es un array asociativo de variables que es pasado al script actual vía 
    parámetros URL (también conocida como cadena de consulta).
    En este caso, pasamos como parámetro URL a la variable 'page' que contiene un valor entero
    tal como 1, 2, 3 etc. que permitirá mostrar un determinado número de pacientes por página
    */
    if (isset($_GET['page'])) {
        $pagina = $_GET['page'];
        $listaPacientes = $paciente->listaPacientes($pagina);

        /*
        Optimizamos la respuesta para la solicitud del listado de pacientes colocando el 
        encabezado (header()) y el código de respuesta a tráves de la función 
        http_response_code() 
        */
        header('Content-Type: application/json');
        echo json_encode($listaPacientes);
        http_response_code(200);
    }
    /*
    En este caso, pasamos como parámetro URL a la variable 'id' que contiene un valor entero
    que permitirá mostrar todos los datos de un solo paciente de acuerdo a su 'id'
    */
    else if (isset($_GET['id'])) {
        $pacienteId = $_GET['id'];
        $datosPaciente = $paciente->obtenerPaciente($pacienteId);
        
        /*
        Optimizamos la respuesta para la solicitud de datos de un solo paciente colocando el 
        encabezado (header()) y el código de respuesta a tráves de la función 
        http_response_code() 
        */
        header('Content-Type: application/json');
        echo json_encode($datosPaciente);
        http_response_code(200);
    }
} 
else if ($_SERVER['REQUEST_METHOD'] == "POST"){
    /*
    leemos los datos del cuerpo de la solicitud y los guardamos como una cadena de caracteres
    en la variable postBody
    */
    $postBody = file_get_contents("php://input");

    $datosArray = $paciente->guardarPaciente($postBody);
    
    /* 
    Devolvemos una respuesta, colocando un encabezado, un código de respuesta y el arreglo
    $response de la clase Respuesta que contiene el 'id' del último paciente agregado
    */
    header('Content-Type: application/json');

    // si existe un campo llamado 'error_id' en el arreglo devuelto por el método guardarPaciente()
    if (isset($datosArray["result"]["error_id"])) {
        $reponseCode = $datosArray["result"]["error_id"];
        http_response_code($reponseCode);
    }
    else {
        http_response_code(200);
    }

    echo json_encode($datosArray);
}
else if ($_SERVER['REQUEST_METHOD'] == "PUT"){
    /*
    leemos los datos del cuerpo de la solicitud y los guardamos como una cadena de caracteres
    en la variable postBody
    */
    $postBody = file_get_contents("php://input");

    $datosArray = $paciente->actualizarPaciente($postBody);
    
    /* 
    Devolvemos una respuesta, colocando un encabezado, un código de respuesta y el arreglo
    $response de la clase Respuesta que contiene el 'id' del paciente que se ha modificado
    recientemente
    */
    header('Content-Type: application/json');

    // si existe un campo llamado 'error_id' en el arreglo devuelto por el método actualizarPaciente()
    if (isset($datosArray["result"]["error_id"])) {
        $reponseCode = $datosArray["result"]["error_id"];
        http_response_code($reponseCode);
    }
    else {
        http_response_code(200);
    }

    echo json_encode($datosArray);
}
else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
    /*
    leemos los datos del cuerpo de la solicitud y los guardamos como una cadena de caracteres
    en la variable postBody
    */
    $postBody = file_get_contents("php://input");

    $datosArray = $paciente->borrarPaciente($postBody);
    
    /* 
    Devolvemos una respuesta, colocando un encabezado, un código de respuesta y el arreglo
    $response de la clase Respuesta que contiene el 'id' del paciente que se ha modificado
    recientemente
    */
    header('Content-Type: application/json');

    // si existe un campo llamado 'error_id' en el arreglo devuelto por el método borrarPaciente()
    if (isset($datosArray["result"]["error_id"])) {
        $reponseCode = $datosArray["result"]["error_id"];
        http_response_code($reponseCode);
    }
    else {
        http_response_code(200);
    }

    echo json_encode($datosArray);
}
else {
    header('Content-Type: application/json');
    $datosArray = $respuesta->error_405();

    echo json_encode($datosArray);
}

?>