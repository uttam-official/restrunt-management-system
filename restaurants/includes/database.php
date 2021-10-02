<?php 
    try{
        $connect= new PDO('mysql:host=localhost;dbname=restaurant','root','Uttam_k9');
                      
    }catch(PDOexception $e){
        echo "connection failed".$e->getMessage();
    }
?>