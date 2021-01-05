<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db_pac);

/*
  Busqueda de datos del paciente
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['dni']) && isset($_GET['codigo_acceso'])){
    	if ($_GET['accion']=="datos"){
			//Recibe un dni y un codigo de acceso.
	      	//Devuelve: nombre, apellidos y estado del paciente, más su historial con nota y fecha.
    	  	$sql = $dbConn->prepare("SELECT nombre, apellido_1, apellido_2, estado FROM paciente WHERE dni=:dni AND codigo_acceso=:cac");
      		$sql->bindValue(':dni', $_GET['dni']);
	      	$sql->bindValue(':cac', $_GET['codigo_acceso']);
    	  	$sql->execute();
        	$sql->setFetchMode(PDO::FETCH_ASSOC);
	        echo json_encode($sql->fetchAll(),JSON_INVALID_UTF8_IGNORE);
			header("HTTP/1.1 200 OK");
	   	   	exit();
    	}
      	elseif ($_GET['accion']=="notas"){
        	$sql = $dbConn->prepare("SELECT nota, fecha, id_usuario, estado FROM nota WHERE dni_paciente=:dni ORDER BY fecha ASC ");
	      	$sql->bindValue(':dni', $_GET['dni']);
    	  	$sql->execute();
      		$sql->setFetchMode(PDO::FETCH_ASSOC);
      		echo json_encode($sql->fetchAll(),JSON_INVALID_UTF8_IGNORE);
	      	
		    header("HTTP/1.1 200 OK");
        	exit();
	  	}
	}
    elseif(isset($_GET['email']) && $_GET['email'] != '') {
        if ($_GET['accion'] == "recupera_codigo") {
	        //Recibe un dni y un codigo de acceso.
	        //Devuelve: nombre, apellidos y estado del paciente, más su historial con nota y fecha.
	        $sql = $dbConn->prepare("SELECT codigo_acceso FROM paciente WHERE email=:email");
	        $sql->bindValue(':email', $_GET['email']);
	        $sql->execute();
	        $sql->setFetchMode(PDO::FETCH_ASSOC);
	        echo json_encode($sql->fetchAll(), JSON_INVALID_UTF8_IGNORE);
	        
	        header("HTTP/1.1 200 OK");
	        exit();
	        // Lo intente desde el servidor pero la funcion mail no va, no se porque
	        /*
	        $res = json_decode(curl_exec($curl), true);
	        echo $res;                 
	        if (count($res) === 1) {
	            echo '1';
	            // the message
	            $msg = "Recuperación de Credenciales\nTu clave es: " . $res;
	            // En windows hay que hcer conviersion
	            $msg = str_replace("\n.", "\n..", $msg);
	            // use wordwrap() if lines are longer than 70 characters
	            //    $msg = wordwrap($msg, 70);
	            // send email
	            $email = $_GET['email'];
	            $headers = array(
	                'From' => 'fedelleos@gmail.com',
	                'Reply-To' => 'fedelleos@gmail.com',
	                'X-Mailer' => 'PHP/' . phpversion()
	            );
	            if (mail($email, "Covid - Recuperación de Credenciales", $msg,$headers)) {
	                echo 'Enviado!';
	                header("HTTP/1.1 200 OK");
	                exit();
	            }                    
	        }
	        */               
	    } 
    /*
    elseif ($_GET['accion'] == "envia_pass") {
        // the message
        $msg = "Recuperación de Credenciales\nTu clave es: " . $res;
        // En windows hay que hcer conviersion
        $msg = str_replace("\n.", "\n..", $msg);
        // use wordwrap() if lines are longer than 70 characters
        //    $msg = wordwrap($msg, 70);
        // send email
        $email = $_GET['email'];
        $headers = array(
            'From' => 'fedelleos@gmail.com',
            'Reply-To' => 'fedelleos@gmail.com',
            'X-Mailer' => 'PHP/' . phpversion()
        );
        if (mail($email, "Covid - Recuperación de Credenciales", $msg,$headers)) {
            echo 'Enviado!';
            header("HTTP/1.1 200 OK");
            exit();
        }
    } 
        */   
           
	}
}   




//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>