<?php
/* Autor fede */
require '../bddsx/config.php';
require '../bdd/config.php';
require '../bdd/consulta.php';
session_start();

if (isset($_POST['submit'])) {   
    $conn = Cuentas::loginAdmin();
    $result = Consulta::updateUsuarios($conn);
    if ($result) {
        switch ($_SESSION['rol']) {
            case 'Administrador':header("Location:../administrador.php");
                break;
            case 'Rastreador':header("Location:../rastreador.php");
                break;
            case 'Médico':header("Location:../medico.php");
                break;
        }
    } else {

        header("Location: cerrarUsuario.php?error='1'");
    }
}

// añadido José Luis

if (isset($_POST['dni'])) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $ser_ext.'/serv_pac.php?accion=update&dni=' . $_POST['dni'] . '&nombre=' . $_POST['nombre']. '&apellido1=' . $_POST['apellido1']. '&apellido2=' . $_POST['apellido2']. '&telefono=' . $_POST['telefono']. '&estado=' . $_POST['estado'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = json_decode(curl_exec($curl), true);

    curl_close($curl);
    if (count($response) === 1) {
        header("Location:../paciente.php");
    }
  

}
