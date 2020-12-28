<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db_pac);

/*
  Busqueda de datos del paciente
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (isset($_GET['dni']) && isset($_GET['codigo_acceso']) && isset($_GET['cas']) && $_GET['cas'] == $cod_acc_serv){
        if ($_GET['accion']=="datos"){
            //Recibe un dni y un codigo de acceso.
            //Devuelve: nombre, apellidos y estado del paciente, más su historial con nota y fecha.
            $sql = $dbConn->prepare("SELECT email, nombre, apellido_1, apellido_2, telefono, estado FROM paciente WHERE dni=:dni AND codigo_acceso=:cac");
            $sql->bindValue(':dni', $_GET['dni']);
            $sql->bindValue(':cac', $_GET['codigo_acceso']);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            echo json_encode($sql->fetchAll(),JSON_INVALID_UTF8_IGNORE);
            header("HTTP/1.1 200 OK");
            exit();
        }
        elseif ($_GET['accion']=="notas"){
            $sql = $dbConn->prepare("SELECT nota, fecha, id_usuario FROM nota WHERE dni_paciente=:dni ORDER BY fecha ASC ");
            $sql->bindValue(':dni', $_GET['dni']);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            echo json_encode($sql->fetchAll(),JSON_INVALID_UTF8_IGNORE);
            
            header("HTTP/1.1 200 OK");
            exit();
        }
        elseif ($_GET['accion']=="update"){
            
            if(isset$_GET['estado']) {
                $sql = $dbConn->prepare("UPDATE paciente SET nombre=:nombre, apellido_1=:apellido1, apellido_2=:apellido2, email=:email, telefono=:telefono, estado=:estado WHERE dni =:dni");
                $sql->bindValue(':estado', $_GET['estado']);

            } else {    // Si es el propio paciente el
                $sql = $dbConn->prepare("UPDATE paciente SET nombre=:nombre, apellido_1=:apellido1, apellido_2=:apellido2, email=:email, telefono=:telefono WHERE dni =:dni");           
            }
            $sql->bindValue(':dni', $_GET['submit']);
            $sql->bindValue(':nombre', $_GET['nombre']);
            $sql->bindValue(':apellido1', $_GET['apellido1']);
            $sql->bindValue(':apellido2', $_GET['apellido2']);
            $sql->bindValue(':email', $_GET['email']);
            $sql->bindValue(':telefono', $_GET['telefono']);
           
            $sql->execute();
            header("HTTP/1.1 200 OK");
            exit(); 

           
        }
    }
}



//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>