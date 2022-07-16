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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <style>
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
    <p><a href="index.php">Home</a></p>
    <?php
    
        $sql="select * from commandes;";
        $sth=$cnx->query($sql);
        $result_command=$sth->fetchAll();
        $commande_total=0;
        
        foreach($result_command as $row_command){
            //type de paiment
            $sql_paiement="select * from paiement where IDPaiment='".$row_command['IDPaiment']."';";
            $sth_paiement=$cnx->query($sql_paiement);
            $result_paiement=$sth_paiement->fetch();
            $type_paiement=$result_paiement['TypePaiment'];
            // la date format
            $time = strtotime($row_command['DateCommande']);
            $myFormatForView = date("d/m/y", $time);
            //ligne commande
            $sql_l_commande="select * from lignecommandes where IDCommande='".$row_command['IDCommande']."';";
            $sth_l_commande=$cnx->query($sql_l_commande);
            $result_l_commande=$sth_l_commande->fetchAll();
            $row_span=count($result_l_commande)+1;
            echo '<table>
            <tr>
                <td>
                    ID commande
                </td>
                <td>
                    Id client
                </td>
                <td>
                mode de paiement
                </td>
                <td>
                    Date
                </td>
                <td colspan="4">
                    lignecommande
                </td>
                
            </tr>
            <tr>
                <td rowspan="'.$row_span.'">';
            echo $row_command['IDCommande'];
                echo '</td>
                <td rowspan="'.$row_span.'">';
            echo $row_command['IDClient'];
            echo '</td>';
            echo 
            '<td rowspan="'.$row_span.'">
                '.$type_paiement.'
            </td>';
            echo '<td rowspan="'.$row_span.'">
                '.$myFormatForView.'
                </td>';
            echo '
                <td>
                    ID produit
                </td>
                <td>
                    Quantite
                </td>
                
                <td>
                    Prix(DH)
                </td>
                <td>
                    totale(DH)
                </td> 
            </tr>';
            
            foreach($result_l_commande as $row_l_command){
                echo '<tr>
                <td> ';
                echo $row_l_command['IDProduit'];
                echo '</td>
                <td>';
                echo $row_l_command['Quantite'];
                
                //prix
                $sql_prix="select * from produits where IDProduit='".$row_l_command['IDProduit']."';";
                $sth_prix=$cnx->query($sql_prix);
                $result_prix=$sth_prix->fetch();
                $prix=$result_prix['Prix'];
                echo '</td>
                <td>';
                echo $prix;
                echo '</td>
                <td>';
                echo $prix*$row_l_command['Quantite'];
                echo '</td>
                </tr>';
                $commande_total+=$prix*$row_l_command['Quantite'];
                
            }
            echo '</table>';
            echo 'Totale command (DH):'.$commande_total.' ';
            echo '<a href="gestion-remove.php?IDCommande='.$row_command['IDCommande'].'">Valider</a>';
            
        }
    ?>
    
    
</body>
</html>