<?php

session_start();

if(isset($_SESSION['rol']) && $_SESSION['rol'] != 'Administrador')   header("Location:./index.php?error='1'");  
require("../bdd/config.php");
require('../bdd/consulta.php');
 

$conn = Cuentas::loginPDO();
$buscar = $_POST['buscar'].'%';
$result = Consulta::listadoAv($conn,$buscar);

     echo "
    <form action='data_source/nuevo_usuario.php' method='post'>
    <tr>
        <td><input name='nombre'></td>
        <td><input name='apellido1'></td>
        <td><input name='apellido2'></td>
        <td><input name='email' type='email'></td>
        <td><input name='password' type='password'></td>
        <td><select id='select' name='rol' >
            <option value='Medico'>Medico</option>
            <option value='Rastreador'>Rastreador</option>
            <option value='Administrador'>Administrador</option>
        </select></td>
        <td><button name='submit' class='btn' type='submit'>Nuevo</button></td>
    </tr>
</form>
    "; 
    $rows = $result->rowCount();
    for($i=1; $i<=$rows; )

        foreach ($result as $key) {
            echo '
            <form action="data_source/actualizar_usuario.php" method="post">
            <tr >
            <th scope="row">'.$i.'</th>
            <td hidden><input name="id" type="number" value="'.$key['ID'].'"></td>
            <td ><input name="nombre" value="'.$key['Nombre'].'"></td>
            <td ><input name="apellido1" value="'.$key['Apellido1'].'"</td>
            <td ><input name="apellido2" value="'.$key['Apellido2'].'"</td>
            <td ><input name="email" type="email" value="'.$key['Email'].'"</td>
            <td ><input name="password" type="password" value="'.$key['Contrasena'].'"</td>
            <td><select id="select" name="rol" >
            <option value="'.$key['Roll'].'">'.$key['Roll'].'</option>
            <option value="Medico">Medico</option>
            <option value="Rastreador">Rastreador</option>
            <option value="Administrador">Administrador</option>
            </select></td>
            <td><button name="submit" class="btn" type="submit">Modificar</button></td>
            </tr>
            </form>
            ';
            $i++;
        }