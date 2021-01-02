<?php
session_start();
if (!isset($_SESSION['rol']))  {
    header("Location: data_source/cerrarUsuario.php?error=1");
}
include '../bddsx/config.php';
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $ser_ext.'/serv_usu.php?accion=lista&contagiado=' . $_POST['contagiado'] .
                    '&asintomatico=' . $_POST['asintomatico']. '&recuperado=' . $_POST['recuperado']. '&fallecido=' . $_POST['fallecido'].'&cas='.$cod_acc_serv,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));   

$response = curl_exec($curl);
curl_close($curl);
$location='';
switch($_SESSION['rol']) {
    case 'Médico': $location = 'medico.php';break;
    case 'Rastreador': $location = 'rastreador.php'; break;
    case 'Administrador': $location = 'administrador.php'; break;
}   
header("Location:../".$location."?pacientes=".$response);


?>