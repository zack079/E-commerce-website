<?php

if(isset($_COOKIE['panier'])){
    foreach($_COOKIE['panier'] as $key=>$value){
        setcookie('panier['.$key.']','',time()-1);
    }
}
    header('location:./panier.php');

?>