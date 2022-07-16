<?php
session_start();
    if(isset($_SESSION['IDUser'])){
        if($_SESSION['IDUser']!=3){
            header('location:index.php');
        }
    }else{
        header('location:index.php');
    }
    include 'php/cnx.php';
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
<h1>users</h1>
<a href="Ajouter.php"><h2>Administration</h2></a>
<a href="ajouter-user.php"><h2>ajouter users</h2></a>

<table>
    


 
<form method="POST" action="php/supprimer-user-traitement.php">
<?php
    $sql='SELECT * FROM clients';
    $sth=$cnx->query($sql);
    $result=$sth->fetchAll(PDO::FETCH_ASSOC);
    echo '<table>';
    echo '<tr>';
    echo '<td>';
        echo 'ID';
    echo '</td>';
    echo '<td>';
        echo 'Nom';
    echo '</td>';
    echo '<td>';
        echo 'Prenom';
    echo '</td>';
    echo '<td>';
        echo 'Adresse';
    echo '</td>';
    echo '<td>';
        echo 'telephone';
    echo '</td>';
    echo '<td>';
        echo 'Ville';
    echo '</td>';
    echo '<td>';
        echo 'Email';
    echo '</td>';
    echo '<td>';
        echo 'type user';
    echo '</td>';
    echo '<td>';
        echo 'select';
    echo '</td>';
    echo '</tr>';
    foreach($result as $row){
        echo '<tr>';
    echo '<td>';
        echo $row['IDClient'];
    echo '</td>';
    echo '<td>';
        echo $row['NomClient'];
    echo '</td>';
    echo '<td>';
        echo $row['PrenomClient'];
    echo '</td>';
    echo '<td>';
        echo $row['Adresse'];
    echo '</td>';
    echo '<td>';
        echo $row['Telephone'];
    echo '</td>';
    echo '<td>';
        echo $row['Ville'];
    echo '</td>';
    echo '<td>';
    echo $row['Email'];
    echo '</td>';
    echo '<td>';
    if($row['IDUser']==1)
        echo 'client';
    elseif($row['IDUser']==2)
        echo 'Manager';
    elseif($row['IDUser']==3)
        echo 'Administrateur';
    echo '</td>';
    echo '<td>';
    echo '<input type="checkbox" name="delete[]" value="'.$row['IDClient'].'">';
    echo '</td>';
    echo '</tr>';
    }
    echo '</table>';

?>
<button type="submit">delete</button>
<button type="reset">reset</button>
</form>
</table>


</body>
</html>