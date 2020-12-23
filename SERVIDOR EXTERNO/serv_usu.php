<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db_usu);
//$input=$_POST;
//if ($_SERVER['REQUEST_METHOD'] == 'POST'){
//  $b=0;
//  foreach ($input as $key => $value) {
//    $b++;
//  }
  
//  header("HTTP/1.1 400 ". $b);
//  exit();
//}

//Servicios de excritura
if ($_SERVER['REQUEST_METHOD'] == 'POST'){


    if ($_POST['accion']=='alta') {
        // Alta de un nuevo paciente
        // recibe: dni, nombre, apellido, apellido_2, email, teléfono, estado, id_usuario,
        // devuelve: nada


        $cod_acc=substr(md5(uniqid(srand(time()))),0,8);

        $secuencia = "INSERT INTO paciente (dni, codigo_acceso, email, nombre, apellido_1, apellido_2, telefono, estado) VALUES (:dni, :cod, :ema, :nom, :ap1, :ap2, :tel, :est);";

        $sql = $dbConn->prepare($secuencia);
        $sql->bindValue(':dni', $_POST["dni"]);
        $sql->bindValue(':cod', $cod_acc);
        $sql->bindValue(':ema', $_POST["email"]);
        $sql->bindValue(':nom', $_POST["nombre"]);
        $sql->bindValue(':ap1', $_POST["apellido_1"]);
        $sql->bindValue(':ap2', $_POST["apellido_2"]);
        $sql->bindValue(':tel', $_POST["telefono"]);
        $sql->bindValue(':est', $_POST["estado"]);
        $sql->execute();        



        header("HTTP/1.1 200 OK");
        exit();
    }

    else if ($_POST['accion']=="nota"){
        // Nota de rastreador o médico. Añade la nueva nota, y actualiza el estado en la tabla de pacientes al de la última nota registrada.
        // recibe: dni, id_usuario, estado, nota
        // devuelve: nada

        // Insertamos la nota
        $fecha=date("Y-m-d H:i:s");
        $secuencia = "INSERT INTO  nota (dni_paciente, fecha, nota, id_usuario, estado) VALUES (:dni, :fec, :not, :idd, :est);";
        $sql = $dbConn->prepare($secuencia);
        $sql->bindValue(':dni', $_POST["dni"]);
        $sql->bindValue(':fec', $fecha);
        $sql->bindValue(':not', $_POST["nota"]);
        $sql->bindValue(':idd', $_POST["id_usuario"]);
        $sql->bindValue(':est', $_POST["estado"]);    
        $sql->execute();

        // modificamos el estado del paciente
        $secuencia = "UPDATE paciente SET estado=:est WHERE dni=:dni";    
        $sql = $dbConn->prepare($secuencia);
        $sql->bindValue(':dni', $_POST["dni"]);
        $sql->bindValue(':est', $_POST["estado"]);    
        $sql->execute();
        echo "ok";
        header("HTTP/1.1 200 OK");
        exit();    

    }
}


// Servicios de consulta
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['accion'])){
        switch ($_GET['accion']) {
            case 'lista':
                // Listado de pacientes
                // recibe: los tres estados con true o false
                // Devuelve una lista de todos los pacientes que cumplan esa condición con DNI, codigo acceso, nombre, apellido, apellido_2, email, teléfono, estado
                $estados=array();
                $secuencia="SELECT * FROM paciente WHERE";
                if ($_GET['contagiado']) {array_push($estados," estado='contagiado'");}
                if ($_GET['curado']) {array_push($estados, " estado='curado'");}
                if ($_GET['fallecido']) {array_push($estados, " estado='fallecido'");}

                for ($i=0; $i<count($estados);$i++) {
                    $secuencia.= $estados[$i]." OR";
                }

                $secuencia=substr($secuencia,0,strlen($secuencia)-3)." ORDER BY apellido_1 ASC, apellido_2 ASC;";

                $sql = $dbConn->prepare($secuencia);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                echo json_encode($sql->fetchAll(),JSON_INVALID_UTF8_IGNORE);
                header("HTTP/1.1 200 OK");        
                exit();
                break;
            
            case 'datos':
                // Datos del paciente para el rastreador
                // recibe: dni del paciente
                // Devuelve: nombre, apellidos, dni, email, teléfono, fecha primer contagio, número de notas registradas
                    
               if (isset($_GET['dni'])){
                          $secuencia = "SELECT * FROM paciente WHERE dni=:dni;";
                    $sql = $dbConn->prepare($secuencia);
                    $sql->bindValue(':dni', $_GET["dni"]);

                    $sql->execute();
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $sql0=$sql->fetchAll();
                    
                    $secuencia = "SELECT id_usuario, fecha FROM nota WHERE dni_paciente=:dni ORDER BY fecha ASC;";
                    $sql = $dbConn->prepare($secuencia);
                    $sql->bindValue(':dni', $_GET["dni"]);

                    $sql->execute();
                    $sql->setFetchMode(PDO::FETCH_ASSOC);                    
                    $sql1=$sql->fetchAll();
                    
                    //print_r($sql0);
                    //print_r($sql1);
                    
                    $sql2=$sql0;
                    $sql2[0]['id_usuario']=$sql1[0]['id_usuario'];
                    $sql2[0]['fecha']=$sql1[0]['fecha'];
                    $sql2[0]['notas']=count($sql1);
                    //print_r($sql2);
                    //print_r($sql->fetchAll());
                    echo json_encode($sql2,JSON_INVALID_UTF8_IGNORE);
                    header("HTTP/1.1 200 OK");        
                      exit();
               }
                break;
                case 'notas':
                    $sql = $dbConn->prepare("SELECT nota, fecha, id_usuario FROM nota WHERE dni_paciente=:dni ORDER BY fecha ASC ");
                    $sql->bindValue(':dni', $_GET['dni']);
                    $sql->execute();
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    echo json_encode($sql->fetchAll(),JSON_INVALID_UTF8_IGNORE);
            
                    header("HTTP/1.1 200 OK");
                    exit();
                    break;
                case 'datos_medico';
            
                break;
            }
    }
}



//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Problema de comn");

?>
