<?php

    class Consulta{
        /* autor:Autor */
        public static function verificarUser($conn){

            $stmt = $conn->prepare("SELECT * FROM `user` WHERE Email = ? AND Contrasena = ?");
            $stmt->bind_param("ss",$_POST["email"],$_POST["password"]); 
            $stmt->execute();
            $vista= $stmt->get_result();
            $conn->close();
            return $vista;
        }

        public static function verificarEmail($conn){

            $stmt = $conn->prepare("SELECT * FROM `user` WHERE Email = ?");
            $stmt->bind_param("s",$_POST["emailNew"]); 
            $stmt->execute();
            $vista= $stmt->get_result();
            return $vista;
        }

        public static function IngresarUsuario($conn){

            $stmt = $conn->prepare("INSERT INTO user (Nombre,Apellido1,Apellido2,Email,Contrasena,Roll) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss",$_POST["nameNew"],$_POST["lastNameNeW1"],$_POST["lastNameNeW2"],$_POST["emailNew"],$_POST["passNew"],$_POST["rolNew"]); 
            $stmt->execute();
            $vista= $stmt->get_result();
            $conn->close();
            return $vista;
        }

        public static function deteleUser($conn){

            $stmt = $conn->prepare("DELETE FROM `user` WHERE ID = ?");
            $stmt->bind_param("s",$_GET["userDelete"]); 
            $stmt->execute();
            $vista= $stmt->get_result(); 
        }

        public static function deteleUsers($conn){

            $stmt = $conn->prepare("DELETE FROM `user` WHERE ID = ?");
            $stmt->bind_param("s",$_GET["userDelete"]); 
            $stmt->execute();
            $vista= $stmt->get_result(); 
        } 

        public static function updateUsers($conn){

            $stmt = $conn->prepare("UPDATE user SET Nombre=?,Apellido1=?,Apellido2=?,Email=?, Contrasena=?,Roll=? WHERE ID = 3");
            $stmt->bind_param("ssssss",$_GET["nameUp"],$_GET["lastNameUp1"],$_GET["lastNameUp2"],$_GET["emailUp"],$_GET["passUp"],$_GET["rolUp"]); 
            $stmt->execute();
            $vista= $stmt->get_result();  

        }

    }


?>