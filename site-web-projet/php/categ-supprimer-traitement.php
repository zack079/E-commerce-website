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
    if(isset($_POST['Categ'])){
        include 'cnx.php';
        $tab=$_POST['Categ'];
        foreach($tab as $id){
            $sql="DELETE FROM `categories` WHERE IDCateg =$id;";
            $sth=$cnx->query($sql);
        }
        header('location:../Ajouter.php');
    }else{
        header('location:../Ajouter.php');
    }
    


?>