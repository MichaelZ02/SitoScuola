<?php
    session_start();
    $nome = $_POST["nomeutente"];
    $pass = $_POST["password"];
    
    if($nome != ""){
        
        if($pass != ""){
            
           //Accesso al database e verifica delle credenziali
           
            $connectionInfo = array("UID" => "fairfoil", "pwd" => "Sonoadmin0", "Database" => "DatabaseDiGIovanni", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
            $serverName = "tcp:servermetropolis.database.windows.net,1433";
            $conn = sqlsrv_connect($serverName, $connectionInfo);
           
           if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
           
           $sql = "SELECT * FROM dipendenti";
           
           $result = sqlsrv_query($conn, $sql);
           
           while($row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)){
               
               if((strcmp($nome,$row["nome"]) == 0) && (strcmp($pass,$row["password"]) == 0)){
                   
                   $accesso = true;
                   
                   $_SESSION["nomedip"] = $row["nome"];
                   $_SESSION["ruolodip"] = $row["ruolo"];          
                   header("location: /Menu/menu.php");
                   exit;
               }                
                    
           }
           
           if(!$accesso){
                include "index.html";  
                echo "<script>alert('Credenziali non valide');</script>";
                
           }
           
        }
        else{
            
            include "index.html";  
            echo "<script>alert('Inserire password');</script>";
                   
        }       
    }
    else{
        include "index.html";
        echo "<script>alert('Inserire nome utente');</script>";      
    }
    
?>