<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 
        <style>
        img{
            height:50px;
            width:50px;
        }
        td{
            border:1px solid black;
        }

    </style>
     -->
    

    <link href="https://mattduck.github.io/generic-css/css/generic-light.min.css" rel="stylesheet" type="text/css"/>

    <title>Document</title>
</head>
<body>
    <?php
        if(!empty($_POST)){
            foreach($_POST as $key=>$value){
                
                if($value==0){
                    setcookie('panier['.$key.']','',time()-1);
                }else{
                    setcookie('panier['.$key.']',$value,time()+3600);
                }
                //actualiser la page
                header("Refresh:0");
            }
        }
    ?>
    <?php 
        include 'php./cnx.php';
        echo '<form method="POST" action="">';
        echo "<table>";
        if(isset($_COOKIE['panier'])){
            $panier=$_COOKIE['panier'];
            foreach($panier as $id=>$quantite){
            $sql='select * from `produits` where IDProduit='.$id.'';
            $sth=$cnx->query($sql);
            if($sth){
                $result=$sth->fetchAll();
                $result=$result[0];
                echo "<tr>";
                    echo "<td>";
                        echo '<img src="data:image/png;base64,'.base64_encode($result['Imagepr']).'"/>';
                    echo "</td>";
                    echo "<td>";
                        echo $result['NomProduit'].' (X'.$quantite.')';
                    echo "</td>";
                    echo "<td>";
                        echo $result['Prix']*$quantite." DH";
                    echo "</td>";
                    echo "<td>";
                        echo '<label for="'.$id.'">Qt:</label><input type="number" id="'.$id.'" name="'.$id.'" value="'.$quantite.'" max="'.$result['UniteEnStock'].'" min="0">';
                    echo "</td>";
                echo "</tr>";
            }
        }
        }
        echo "</table>";
        echo '<button type="submit">sauvegarder panier</button>';
        echo '</form>';
        echo "<br><br>";

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
        <div >
            Totale '.$somme.' DH
        </div>';
    ?>
    <a href='panier_init.php'>
        vider mon panier
    </a>
    <br>
    <a href="index.php">
        Home page
    </a>
    <br>
    <?php
        if($somme!=0){
            if(isset($_SESSION['IDClient'])){
                echo '<a href="paiement.php">
                        Acheter!
                    </a>';
            }else{
                echo '<a href="login.php">
                        Acheter!
                    </a>';
            }
            
        }

    ?>
    
   
</body>
</html>