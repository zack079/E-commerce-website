<?php
$username="root";
$host="localhost";
$db="data_websit";
$dsn= "mysql:host=$host;dbname=$db";
try{
    $cnx= new PDO($dsn,$username,"");
if($cnx){
}
}
catch(PDOEXception $a){
    $err=$a->getMessage();
    echo $err;
    exit();
}
?>