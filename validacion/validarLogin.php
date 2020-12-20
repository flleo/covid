<?php
    /* Autor adrian */
    require('../bdd/config.php');
    require('../bdd/consulta.php');

    if(isset($_POST['email']) &&  isset($_POST['password'])){

        $conn = Cuentas::login();
        $result = Consulta::verificarUser($conn);

        $num_row = $result->num_rows;

        if($num_row ===1){

            foreach ($result as $key) {
                
                $_SESSION['rol'] = $key['Roll'];
                $_SESSION['nombre'] = $key['Nombre'];  
                
                header("Location:../modificar_usuario.php");
            }

        }else{
            
            header("Location:../index.php?error='1'");
        }
    }


?>