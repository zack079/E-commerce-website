<?php
    session_start();
    include 'php./cnx.php';
    if(isset($_SESSION['IDUser'])){
        if($_SESSION['IDUser']!=2)
            header('location:index.php');
    }else{
        header('location:index.php');
    }
?>
<?php
    session_start();
    include 'php./cnx.php';
    if(isset($_GET['IDCommande'])){
        $IDCommande=$_GET['IDCommande'];
        //commande
        $sql="select * from `commandes` where IDCommande=$IDCommande";
        $sth=$cnx->query($sql);
        $result_command=$sth->fetch();
        $IDPaiment=$result_command['IDPaiment'];
        //ligne commande
        $sql_l_commande="select * from `lignecommandes` where IDCommande='".$result_command['IDCommande']."';";
        $sth_l_commande=$cnx->query($sql_l_commande);
        $result_l_commande=$sth_l_commande->fetchAll();
        //produit
        foreach($result_l_commande as $row_l_command){
            $IDProduit=$row_l_command['IDProduit'];
            $Qunatite=$row_l_command['Quantite'];
            //select quantite
            $sql_UniteEnStock="select * from produits where IDProduit='".$row_l_command['IDProduit']."';";
            $sth_UniteEnStock=$cnx->query($sql_UniteEnStock);
            $result_UniteEnStock=$sth_UniteEnStock->fetch();
            $UniteEnStock_old=$result_UniteEnStock['UniteEnStock'];
            $UniteEnStock_new=$UniteEnStock_old-$Qunatite;
            //update quantite
            echo 'stock:'.$UniteEnStock_old;
            echo '<br> produit:'.$IDProduit;

            $sql = "UPDATE produits SET UniteEnStock= :UniteEnStock_new WHERE IDProduit= :IDProduit";
            $query = $cnx ->prepare($sql);
            $query->execute(array(
            ':UniteEnStock_new' => $UniteEnStock_new,
            ':IDProduit' => $IDProduit
            ));
        
            echo '<br>';
            if($query){
                echo 'cool<br>';
            }else{
                echo 'uncool<br>';
            }
            
        }

        
        $sql="DELETE FROM `paiement` WHERE IDPaiment =$IDPaiment;";
        try{
            $sth=$cnx->query($sql);
            header('location:gestion.php');
        }catch(PDOException $e){
            header('location:gestion.php');
        }
        header('location:gestion.php');
}

?>