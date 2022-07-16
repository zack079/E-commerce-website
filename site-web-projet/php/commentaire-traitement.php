<?php
    session_start();
    if(!isset($_SESSION['IDClient']) ){
        header('location:../login.php');
    }else{
        if(isset($_POST['comment'])){
            $comment=$_POST['comment'];
            $IDProduit=$_POST['IDProduit'];
            $IDClient= $_SESSION['IDClient'];
            include 'cnx.php';
            $sql="insert into commentaires(TextDeCommentaire , IDClient ,IDProduit)
                        values('{$comment}','{$IDClient}','{$IDProduit}');";
            $sth=$cnx->query($sql);
            header('location:../article.php?souscateg='.$IDProduit);
        }else{
            header('location:../login.php');
        }

    }
    
    
?>