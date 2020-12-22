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


?>