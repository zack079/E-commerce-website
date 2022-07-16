<?php
session_start();
    if(isset($_SESSION['IDUser'])){
        if($_SESSION['IDUser']!=3){
            header('location:index.php');
        }
    }else{
        header('location:index.php');
    }
?>
<?php
    if(isset($_POST['delete'])){
        include 'cnx.php';
        $tab=$_POST['delete'];
        foreach($tab as $id){
            $sql="DELETE FROM `produits` WHERE IDProduit =$id;";
            $sth=$cnx->query($sql);
        }
        header('location:../supprimer-article.php');
    }else{
        header('location:../supprimer-article.php');
    }
    


?>