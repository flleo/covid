<?php
    // Jose Luis
    require '../config/config.php';


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
               
                $_SESSION['id'] = $key['ID'];
                $_SESSION['rol'] = $key['Roll'];               
                $_SESSION['nombre'] = $key['Nombre']; 
                $_SESSION['apellido1'] = $key['Apellido1'] ;
                $_SESSION['apellido2'] = $key['Apellido2'];
                $_SESSION['email'] = $key['Email'];
                $_SESSION['password'] = $key['Contrasena'];
             
                switch($_SESSION['rol']) {
                    case 'Administrador':   header("Location:../administrador.php");break;
                    case 'Rastreador':      header("Location:../rastreador.php");break;
                    case 'Medico':          header("Location:../medico.php");break;
                    case 'Paciente':        header("Location:../paciente.php");break;
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
            CURLOPT_URL => $ser_ext.'serv_pac.php?accion=datos&dni='.$_POST['dni'].'&codigo_acceso='.$_POST['code'].'&cas='.$cod_acc_serv,
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
            print_r($response[0]);
            $_SESSION['dni'] = $_POST['dni']; 
            $_SESSION['codigo_acceso'] = $_POST['code'];
            $_SESSION['estado'] = $response[0]['estado'];
            $_SESSION['nombre'] = $response[0]['nombre']; 
            $_SESSION['apellido_1'] = $response[0]['apellido_1'] ;
            $_SESSION['apellido_2'] = $response[0]['apellido_2'];
            header("Location:../paciente.php");
        }
        

    }


?>