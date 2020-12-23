<?php
    /* Autor adrian */
    require('../bdd/config.php');
    require('../bdd/consulta.php');
    session_start();

    if(isset($_POST['email']) &&  isset($_POST['password'])){

        $conn = Cuentas::login();
        $result = Consulta::verificarUser($conn);
        

        $num_row = $result->num_rows;

        if($num_row ===1){

            foreach ($result as $key) {
                if(!isset($key['Roll'])) {
                    $_SESSION['rol'] = 'paciente';
                    $_SESSION['cod_acceso'] = $key['Cod_acceso']; 
                    $_SESSION['telefono'] = $key['Telefono'] ;
                    $_SESSION['estado'] = $key['Estado'];
                } else {
                    $_SESSION['rol'] = $key['Roll'];
                }
                $_SESSION['nombre'] = $key['Nombre']; 
                $_SESSION['apellido1'] = $key['Apellido1'] ;
                $_SESSION['apellido2'] = $key['Apellido2'];
                $_SESSION['email'] = $key['Email'];
                $_SESSION['password'] = $key['Contrasena'];
             
                switch($_SESSION['rol']) {
                    case 'administrador':   header("Location:../administrador.php");break;
                    case 'rastreador':      header("Location:../rastreador.php");break;
                    case 'medico':          header("Location:../medico.php");break;
                    case 'paciente':        header("Location:../paciente.php");break;
                }
                
            }

        }else{
            
            header("Location:../index.php?error='1'");
        }
    }

    // añadido José Luis

    if(isset($_POST['dni']) &&  isset($_POST['code'])){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://192.168.0.57/vcserver/serv_pac.php?accion=datos&dni='.$_POST['dni'].'&codigo_acceso='.$_POST['code'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = json_decode(curl_exec($curl),true);

        curl_close($curl);
        if (count($response)===1) {
            $_SESSION['dni'] = $response[0]['nombre']; 
            $_SESSION['codigo_acceso'] = $response[0]['codigo_acceso'];
        }
        header("Location:../paciente.php");

    }


?>