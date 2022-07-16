<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article</title>
    <!-- le feuilles du style css -->
    <link rel="stylesheet" href="css/art.css">
    <!-- normalize css -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- font family -google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <!-- all mini file icone -->
    <link rel="stylesheet" href="css/all.min.css">
    
</head>
<body>
    <?php
    //faire la conexion
    include 'php./cnx.php';
    //savoire quelle page
    if(isset($_GET['souscateg'])){
        $souscateg=$_GET['souscateg'];
        //requete de test du lien
        $sql='select count(*) as nmb from `produits` where IDProduit='.$souscateg.'';
        $sth=$cnx->query($sql);
        $result=$sth->fetch();
        $result=$result['nmb'];
        //si le produit exist
        if($result==1){
        //ajouter cookies si l'utilisateur a clické sur 'ajouter au panier'
        if(isset($_POST['quantite'])){
            //l'index du table est ID du produit, la valeur associé est la quantité
            setcookie('panier['.$_GET['souscateg'].']',$_POST['quantite'],time()+3600);
            //actualiser la page
            header("Refresh:0");
        }
        //calculer le totale du panier
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
        
        //afficher totale du panier
        echo '
        <div class="panier" style="float:right;">
            <i class="fa-solid fa-cart-arrow-down"><a class="titre" href="panier.php">panier '.$somme.' DH</a></i>
        </div>
        <a href="index.php" >Home</a>';

        
        //afficher le produit

        $sql='select * from `produits` where IDProduit='.$souscateg.'';
        $sth=$cnx->query($sql);
        $result=$sth->fetchAll();
        $result=$result[0];

        echo '<div class="container">';
        echo '<div class="articleLogo">';
        echo '<img src="data:image/png;base64,'.base64_encode($result['Imagepr']).'"/>'.'<br>';
        echo '</div>
        <div class="infos">';    
        echo '<h1>'.$result['Description'].'</h2>';
        echo '<p class="prix">';
        echo $result['Prix'].' dh';       
        echo '</p>'; 
        $UniteEnStock=$result['UniteEnStock'];
        echo '<p class="prix">';
        echo 'stock:'.$UniteEnStock;       
        echo '</p>'; 
        echo '<p class="prix">';
        echo '<a href="php/pdf.php?IDProduit='.$souscateg.'">PDF</a>';       
        echo '</p>'; 
        echo '   
                <form method="POST" action="">
                    <label for="quantite">Quantite</label>
                    <input type="number" id="quantite" min="1" name="quantite" max="'.$UniteEnStock.'">
                    <br><br><br>
                    <button type="submit">ajouter au panier</button>
                </form>
                <br><br><br>
            </div>
            <br><br>';
        //ajouter commentaires    
        echo '    
            <div class="infos">Commentaire<div>
            <form action="php/commentaire-traitement.php" method="post">
                <textarea name="comment" id="comment" style="font-family:sans-serif;font-size:1.2em;" maxlength="150" name="comment" required></textarea>        
                <input type="submit" value="Submit">
                <input type="hidden" name="IDProduit" value="'.$souscateg.'">
            </form>
        </div>
        ';
        //afficher commentaires
        echo 'commentaires:<br>';
        $sql='select * from `commentaires`where IDProduit='.$souscateg;
        $sth=$cnx->query($sql);
        $result=$sth->fetchAll(PDO::FETCH_ASSOC);
        echo '<br><br>';
        echo '<table>';
        foreach($result as $row){
            $sql='select * from `clients` where IDClient='.$row['IDClient'].'';
            $sth=$cnx->query($sql);
            $result_1=$sth->fetch();
            $PrenomClient=$result_1['PrenomClient'];
            echo '<tr>';
                echo '<td>';
                    echo $PrenomClient.':';
                echo '</td>';
                echo '<td>';
                    echo $row['TextDeCommentaire'];
                echo '</td>';
            echo '</tr>';
        }
        echo '</table>';



        }else{
            echo 'ERROR 404!';
        }

    }else{
        echo 'ERROR 404!';
    }   

?>


</body>
</html>