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
    <title>Supprimer</title>
    <link rel="stylesheet" href="css/ajouter.css">
    <!-- <style>
        img{
            height:200px;
            width:auto;
        }
        table,td {
            border: 1px solid black;
            border-collapse: collapse;
            margin:10px;
        }
        td{
            padding:10px;
            text-align:center;
        }
    </style> -->
    <link href="https://mattduck.github.io/generic-css/css/generic-light.min.css" rel="stylesheet" type="text/css"/>

</head>
<body>
<h1>supprimer article</h1>
<a href="Ajouter.php"><h2>Administration</h2></a>

<?php
    include 'php./cnx.php';
    $sql='select * from `produits`;';
    $sth=$cnx->query($sql);
    $result=$sth->fetchAll();
    echo '<form method="POST" action="php/supprimer-article-traitement.php">';
    echo '<table>';
    echo '
    <tr>
         <td>Produit image</td>
         <td>Produit nom</td>
         <td>Selectionner</td>
    </tr>';
    foreach($result as $row){
        echo '<tr>';
            echo '<td>';
                echo '<img src="data:image/png;base64,'.base64_encode($row['Imagepr']).'"/>';
            echo '</td>';
            echo '<td>';
                echo $row['NomProduit'];
            echo '</td>';   
            echo '<td>';
                echo '<input type="checkbox" name="delete[]" value="'.$row['IDProduit'].'">';
            echo '</td>';    
        echo '</tr>';
    }
    echo '</table>';
    echo '<button type="submit">Delete</button><button type="reset">reset</button>'
?>


</body>
</html>