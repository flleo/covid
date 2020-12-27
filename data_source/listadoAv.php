<?php

session_start();

if(isset($_SESSION['rol']) && $_SESSION['rol'] != 'Administrador')   header("Location:./index.php?error='1'");  
require("../bdd/config.php");
require('../bdd/consulta.php');
 

$conn = Cuentas::loginPDO();
$buscar = $_POST['buscar'].'%';
$result = Consulta::listadoAv($conn,$buscar);

    $rows = $result->rowCount();
    for($i=1; $i<=$rows; )
        foreach ($result as $key) {
            echo "
            <div class='listado'>
            <form action='data_source/actualizar_usuario.php' class='d-flex justify-content-around p-3 m-2 border-bottom' method='post'>
                <div class='form-group'>
                    <input name='nombre' type='text' value=".$key['Nombre'].">
                </div>
                <div class='form-group'>
                    <input name='apellido1' type='text' value=".$key['Apellido1'].">
                </div>
                <div class='form-group'>
                    <input name='apellido2' type='text' value=".$key['Apellido2'].">
                </div>
                <div class='form-group'>
                    <input name='email' type='text' value=".$key['Email'].">
                </div>
                <div class='form-group'>
                    <input name='password' type='text' value=".$key['Contrasena'].">
                </div>
                <div class='form-group'>
                    <select id='select' name='rol' >
                        <option value=".$key['Roll'].">".$key['Roll']."</option>
                        <option value='Medico'>Medico</option>
                        <option value='Rastreador'>Rastreador</option>
                        <option value='Administrador'>Administrador</option>
                    </select>
                </div>
                    <button type='submit' name='submit' value=".$key['ID']." class='btn btn-primary'>Submit</button>
            </form>
        </div>
            
            ";
            $i++;
        }