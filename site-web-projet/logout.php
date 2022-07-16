<?php
    session_start();
    if(isset($_COOKIE['panier'])){
        foreach($_COOKIE['panier'] as $key=>$value){
            setcookie('panier['.$key.']','',time()-1);
        }
    }
    if(isset($_SESSION['NomClient'])){
        echo "logged out as :".$_SESSION['NomClient'];
        echo "<br> redirecting to home page after 5 seconds...";    
        session_destroy();

    }
    
    header('location:index.php');
    
?>