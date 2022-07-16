<?php
session_start();
require 'php./cnx.php';
if(isset($_POST['paiement']) && isset($_SESSION['IDClient'])){
    //inserer paiement
    $paiement_type=$_POST['paiement'];
    $sql="insert into paiement (DatePaiment,TypePaiment) 
    values(SYSDATE(),'{$paiement_type}');";
    $sth=$cnx->query($sql);
    $IDPaiment=$cnx->lastInsertID();
    //inserer dans commande
    if($sth){
        $IDClient=$_SESSION['IDClient'];
        //inserer dans commande
        $sql="insert into commandes(DateCommande, IDPaiment,IDClient)
        values(SYSDATE(),'{$IDPaiment}','{$IDClient}');";
        $sth=$cnx->query($sql);
        $IDCommande=$cnx->lastInsertID();
        if($sth){
            if(isset($_COOKIE['panier'])){
                $panier=$_COOKIE['panier'];
                foreach($panier as $idproduit=>$quantite){
                    //inserer dans lignecommandes
                    $sql="insert into lignecommandes(Quantite , IDCommande ,IDProduit )
                        values('{$quantite}','{$IDCommande}','{$idproduit}');";
                    $sth=$cnx->query($sql);
                }
            }
            header('location:panier_init.php');
        }
    }else{
    header('location:index.php');
    }
}else{
    header('location:index.php');
}

?>

