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
    echo "hola post";
}
else if ($_SERVER['REQUEST_METHOD'] == "PUT"){
    echo "hola put";
}
else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
    echo "hola delete";
}
else {
    header('Content-Type: application/json');
    $datosArray = $respuesta->error_405();

    echo json_encode($datosArray);
}

?>