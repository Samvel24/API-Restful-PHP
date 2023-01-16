<!DOCTYPE html>
<html lang="en">
<head>
    <!--Documentación de la API usando HTML y CSS-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Pruebas</title>
    <link rel="stylesheet" href="assets/estilo.css" type="text/css">
</head>
<body>
<div  class="container">
    <h1>Api de pruebas</h1>
    <div class="divbody">
        <h3>Auth - login</h3>
        <code>
           POST  /auth
           <br>
           {
               <br>
               "usuario" :"",  -> REQUERIDO
               <br>
               "password": "" -> REQUERIDO
               <br>
            }
        
        </code>
    </div>      
    <div class="divbody">   
        <h3>Pacientes</h3>
        <code>
           GET  /paciente?page=$numeroPagina
           <br>
           GET  /paciente?id=$idPaciente
        </code>
        <code>
           POST  /paciente
           <br> 
           {
            <br> 
               "nombre" : "",               -> REQUERIDO
               <br> 
               "dni" : "",                  -> REQUERIDO
               <br> 
               "correo":"",                 -> REQUERIDO
               <br> 
               "codigoPostal" :"",             
               <br>  
               "genero" : "",        
               <br>        
               "telefono" : "",       
               <br>       
               "fechaNacimiento" : "",      
               <br>         
               "token" : ""                 -> REQUERIDO        
               <br>       
           }
        </code>
        <code>
           PUT  /paciente
           <br> 
           {
            <br> 
               "nombre" : "",               
               <br> 
               "dni" : "",                  
               <br> 
               "correo":"",                 
               <br> 
               "codigoPostal" :"",             
               <br>  
               "genero" : "",        
               <br>        
               "telefono" : "",       
               <br>       
               "fechaNacimiento" : "",      
               <br>         
               "token" : "" ,                -> REQUERIDO        
               <br>       
               "pacienteId" : ""   -> REQUERIDO
               <br>
           }
        </code>
        <code>
           DELETE  /paciente
           <br> 
           {   
               <br>    
               "token" : "",                -> REQUERIDO        
               <br>       
               "pacienteId" : ""   -> REQUERIDO
               <br>
           }
        </code>
    </div>
</div>
    
</body>
</html>