<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport</title>
    <!-- le feuilles du style css -->
    <link rel="stylesheet" href="css/leon.css">
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
    session_start();
    ?>
   <div class="header">
       <div class="container">
           <div class="topheader">
               <div class="unephrase"><img src="https://cdn.shopify.com/s/files/1/0666/9741/t/820/assets/freeshipping-icon-blue.svg?v=17262934127154574023" alt="une image"> Free Shipping Over $55*</div>
               <div class="leslogins">
                <?php 
                    //afficher administration si iduser==3 (administrateur)
                
                ?>
                <?php if(isset($_SESSION['IDUser'])):?>
                    <?php if($_SESSION['IDUser']==3):?>
                        <i class="fa-solid fa-user"><a href="Ajouter.php" class="titre">Administration</a> </i>
                    <?php endif;?>
                <?php endif;?>
                <?php if(!isset($_SESSION['IDClient'])):?>
                    <i class="fa-solid fa-right-to-bracket"><a href="login.php" class="titre">Login</a> </i>
                <?php else: ?>
                    <i class="fa-solid fa-user"><a href="#" class="titre"><?php echo $_SESSION['NomClient']?></a> </i>
                    <i class="fa-solid fa-arrow-right-from-bracket"><a href="logout.php" class="titre">Logout</a> </i>
                <?php endif; ?>
                <i class="fa-solid fa-magnifying-glass"><a href="search.php" class="titre">Search</a> </i>
               </div>
           </div>
       </div>
       <div class="underheader">
           <div class="logomenu">
               <img src="images/logopric.PNG" alt="logo">
               <div class="menu">
                   <a href="index.php" class="underMenu">HOME</a>
                   <a href="#titredeCa" id="cate" class="underMenu">CATEGORIES
                       <ul class="cat">
                           <li>Sport</li>
                           <li>Kitchen</li>
                           <li>Electronique</li>
                           <li>Clothes</li>
                       </ul>
                   </a>
                   <a href="#" class="underMenu">ABOUT</a>
                   <a href="#" class="underMenu">CONTACT</a>
               </div>
           </div>
           <!-- afficher total panier -->
           <?php 
                include 'php./cnx.php';
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
                <div class="panier">
                    <i class="fa-solid fa-cart-arrow-down"><a class="titre" href="panier.php">panier '.$somme.' DH</a></i>
                </div>';
            
            
            ?>
       </div>
   </div>
   <div class="imageFrame">
       <img id="img1" src="images/fit.jpg" alt="">
       <img id="img2" src="images/adidas-predator-sapphire-web_1500x.jpg" alt="">
   </div>

   <!-- categories -->
<?php
    
    include 'php./cnx.php';
    if(isset($_GET['categ'])){
        $categ=$_GET['categ'];
    }

    $sql='select * from `souscateg` where IDCateg='.$categ.'';
    $sth=$cnx->query($sql);
    $result=$sth->fetchAll(PDO::FETCH_ASSOC);

    echo "<br><br>";
    foreach($result as $row){
        //afficher le sous categorie
        echo '<div class="categories">';
        echo '<p class="titredeCat">'.$row['NomSousCateg'].'</p>';
        echo '<div class="lesCate">';
        $sql='select * from `produits` where IDSousCateg='.$row['IDSousCateg'].'';
        $sth=$cnx->query($sql);
        $result_1=$sth->fetchAll(PDO::FETCH_ASSOC);
        foreach($result_1 as $row_1){
            //afficher le article du sous categorie
            echo '<a href="article.php?souscateg='.$row_1['IDProduit'].'">';
            echo '<img src="data:image/png;base64,'.base64_encode($row_1['Imagepr']).'"/>'.'<br>';
            echo '<p>'.$row_1['NomProduit'].'</p>';
            echo '<p class="prix">'.$row_1['Prix'].' dh</p>';
            echo '</a>';

        }
        echo '
        </div>
        </div>';

    }
?>
</diV>
</body>
</html>