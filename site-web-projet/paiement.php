<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://mattduck.github.io/generic-css/css/generic-light.min.css" rel="stylesheet" type="text/css"/>

</head>
<body>
    <!-- type de paiement -->
    <form action="paiement-traitement.php" method="POST">
        <span>
            Type de paiement:
        </span>
        <input type="radio" name="paiement" id="cash" value='cash' required >
        <label for="cash">Paiement cash à la livraison</label>
        <input type="radio" name="paiement" id="paypal" value='paypal'>
        <label for="paypal">Paypal</label>
        <br>
        <?php
            include 'php./cnx.php';
            $somme=0;
            if(isset($_COOKIE['panier'])){
                $panier=$_COOKIE['panier'];
                foreach($panier as $id=>$quantite){
                    $sql='select Prix from `produits` where IDProduit='.$id.'';
                    $sth=$cnx->query($sql);
                    if($sth){
                    $result=$sth->fetchAll();
                    $result=$result[0];
                    $somme+=$result['Prix']*$quantite;}
                }
            }
            //control de lien
            if($somme==0 || !isset($_SESSION['IDClient']) ){
                header('location:index.php');
            }
            //afficher totale du panier
            echo '
            <div >
                Totale :'.$somme.' DH
            </div>';
        ?>
        <a href="panier.php">Retourner au panier</a>
        <br>
        <button type="submit">Commender</button>
    </form>
</body>
</html>