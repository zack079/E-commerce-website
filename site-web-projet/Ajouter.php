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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="css/ajouter.css">
</head>
<body>
 <div class="tous">
    <div class="header">
        <h2>administration</h2>
    </div>
    <a href="supprimer-article.php">
        <h2>supprimer articles</h2>
    </a>
    <a href="user.php">
        <h2>users</h2>
    </a>
    
    <div class="Ajoute">
        <div class="ajouteCat">
            <fieldset>
                <legend>Categorie</legend>
                <form action="" method="post" enctype="multipart/form-data">
                    <table class="CateTable1">
                        <tr>
                            <td><label for="NomDeCat">Nom De Categorie </label></td>
                            <td>:
                                <input type="text" name="NomDeCat" id="NomDeCat" placeholder="Entrer le nom du Categorie"></td>
                        </tr>
                        <tr>
                           <td><label for="ImgDuCat">Image </label></td>
                           <td>:
                               <input type="file" name="image" id="ImgDuCat" accept="image/*"></td>
                       </tr>
                    </table>  
                    <div class="LesButtons">
                        <input type="submit" value="Valider" name='validercat'> 
                        <input type="reset" value="Reset"></div>
                </form> 
            </fieldset>   
        </div>
        <div class="ajouteSousCat" method="post">
            <fieldset>
                <legend>Sous Categorie</legend>
                <form action="" method="post">
                    <table class="CateTable2">
                        <tr>
                            <td><label for="NomDeSousCat">Nom De Sous Categorie </label></td>
                            <td>:
                                <input type="text" name="NomDeSousCat" id="NomDeSousCat" placeholder="Entrer le nom du Sous Categorie"></td>
                        </tr>
                       <tr>
                           <td><label for="CatAppartient">Le Categorie auquel appartient</label></td>
                           <td>:
                               <select name="CatAppartient" id="CatAppartient">
                                   <?php
                                        include 'php/cnx.php';
                                        $sql='select * from categories';
                                        $sth=$cnx->query($sql);
                                        $result=$sth->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result as $row){
                                            echo '<option value="'.$row['IDCateg'].'">'.$row['NomCateg'].'</option>';
                                        }
                                   ?>
                               </select>
                           </td>
                       </tr>
                    </table>
                    <div class="LesButtons">
                        <input type="submit" value="Valider" name="Validersc"> 
                        <input type="reset" value="Reset"></div>
                </form>
            </fieldset> 
        </div>
        <div class="ajoutProduit">
            <fieldset class="lastField">
                <legend>Produit</legend>
                <form action="" method="post" enctype="multipart/form-data">
                    <table class="CateTable3">
                        <tr>
                            <td><label for="NomDeProduit">Nom De Produit </label></td>
                            <td>:
                                <input type="text" name="NomDeProduit" id="NomDeProduit" placeholder="Entrer le nom du Produit"></td>
                        </tr>
                        <tr>
                           <td><label for="ImgDeProduit">Image </label></td>
                           <td>:
                               <input type="file" name="ImgDeProduit" id="ImgDeProduit" accept="image/*"></td>
                       </tr>
                       <tr>
                           <td><label for="SousCatAppartient">Le Sous Categorie auquel appartient</label></td>
                           <td>:
                           <?php
                                include 'php/cnx.php';
                                $sql='select * from `categories`';
                                $sth=$cnx->query($sql);
                                $result=$sth->fetchAll(PDO::FETCH_ASSOC);
                                echo '<select name="SousCatAppartient" id="SousCatAppartient">';
                                foreach($result as $row){
                                    echo '<optgroup label="'.$row['NomCateg'].'">';
                                    $sql='select * from `souscateg` where IDCateg='.$row['IDCateg'];
                                    $sth=$cnx->query($sql);
                                    $result_1=$sth->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result_1 as $row_1){
                                        echo '<option value="'.$row_1['IDSousCateg'].'">'.$row_1['NomSousCateg'].'</option>';
                                    }
                                    echo '</optgroup>';
                                }
                                echo '</select>';
                            ?>
                           </td>
                       </tr>
                       <tr>
                           <td><label for="Quantite">Quantité</label></td>
                           <td>: 
                               <input type="number" name="Quantite" id="Quantite">
                           </td>
                       </tr>
                       <tr>
                           <td><label for="Prix">Prix</label></td>
                           <td>: 
                               <input type="number" name="Prix" id="Prix">
                           </td>
                       </tr>
                       <tr>
                           <td><label for="Desc">Description</label></td>
                           <td>
                               <textarea name="Desc" id="Desc" cols="40" rows="5"></textarea>
                           </td>
                       </tr>
                    </table> 
                    <div class="LesButtons"><input type="submit" value="Valider" name="Validerpr"> <input type="reset" value="Reset"></div>
                </form>
            </fieldset>   
        </div>
        <div class="ajoutProduit">
            <fieldset class="lastField">
                <legend>supprimer sous categorie</legend>
                <form action="php/sous-categ-supprimer-traitement.php" method="post" enctype="multipart/form-data">
                    <table class="CateTable3">
                       <tr>
                           <td><label for="SousCatAppartient">Le Sous Categorie auquel appartient</label></td>
                           <td>:
                           <?php
                                include 'php/cnx.php';
                                $sql='select * from `categories`';
                                $sth=$cnx->query($sql);
                                $result=$sth->fetchAll(PDO::FETCH_ASSOC);
                                echo '<select name="SousCat[]" id="SousCat" multiple required>';
                                foreach($result as $row){
                                    echo '<optgroup label="'.$row['NomCateg'].'">';
                                    $sql='select * from `souscateg` where IDCateg='.$row['IDCateg'];
                                    $sth=$cnx->query($sql);
                                    $result_1=$sth->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result_1 as $row_1){
                                        echo '<option value="'.$row_1['IDSousCateg'].'">'.$row_1['NomSousCateg'].'</option>';
                                    }
                                    echo '</optgroup>';
                                }
                                echo '</select>';
                            ?>
                           </td>
                       </tr>
                    </table> 
                    <div class="LesButtons"><input type="submit" value="Valider" name="Validerpr"> <input type="reset" value="Reset"></div>
                </form>
            </fieldset>   
        </div>
        <div class="ajoutProduit">
            <fieldset class="lastField">
                <legend>supprimer categorie</legend>
                <form action="php/categ-supprimer-traitement.php" method="post" enctype="multipart/form-data">
                    <table class="CateTable3">
                        <tr>
                            <td><label for="CatAppartient">Le Categorie auquel appartient</label></td>
                            <td>:
                                <select name="Categ[]" id="CatAppartient" multiple>
                                    <?php
                                            include 'php/cnx.php';
                                            $sql='select * from categories';
                                            $sth=$cnx->query($sql);
                                            $result=$sth->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($result as $row){
                                                echo '<option value="'.$row['IDCateg'].'">'.$row['NomCateg'].'</option>';
                                            }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table> 
                    <div class="LesButtons"><input type="submit" value="Valider" name="Validerpr"> <input type="reset" value="Reset"></div>
                </form>
            </fieldset>   
        </div>
    </div>
 </div>
 <?php
    ;
if(isset($_POST['validercat'])){
        if(empty($_POST['NomDeCat']))
         
          echo "saisir le nom categorie";
        elseif(empty($_FILES))
            echo "saisir l'image de Categorie";
       
        else{
        $imgData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
       $sqe="INSERT INTO `categories`(`NomCateg`, `imgcat`) VALUES ('".$_POST['NomDeCat']."','".$imgData."');";
       $cnx->exec($sqe);
          echo"la categorie est bien enregistrer";
        
        }     
}
    if(isset($_POST['Validersc'])){
        if(empty($_POST['NomDeSousCat']))
            echo "saisir le nom de sous Categorie";
         elseif(empty($_POST['CatAppartient']))
                 echo "saisir l\'id categorie";
         else{
        $sqe1="INSERT INTO `souscateg`(`NomSousCateg`, `IDCateg`) VALUES ('".$_POST['NomDeSousCat']."','".$_POST['CatAppartient']."');";
        $cnx->exec($sqe1);
  
        echo "le sous categorie est bien enregistrer";
         }}  
    if(isset($_POST['Validerpr'])){
        $imgData = addslashes(file_get_contents($_FILES['ImgDeProduit']['tmp_name']));
        $sqe2="INSERT INTO `produits`( `NomProduit`, `Prix`, `UniteEnStock`, `Description`, `IDSousCateg`, `Imagepr`)
         VALUES ('".$_POST['NomDeProduit']."','".$_POST['Prix']."',
         '".$_POST['Quantite']."','".$_POST['Desc']."','".$_POST['SousCatAppartient']."','".$imgData."');";
         $cnx->exec($sqe2);
    }
    ?>
</body>
</html>