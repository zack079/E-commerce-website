 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>
 <body>
     <p>test</p>
     <?php
        include 'php./cnx.php';
        $sql='UPDATE `produits`
        SET UniteEnStock  = 3
        WHERE  IDProduit=1;';
        $sth=$cnx->query($sql);
        if($sth){
            echo 'cool';
        }else{
            echo 'not cool';
        }
     ?>
 </body>
 </html>
