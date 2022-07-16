<?php

    include '..\fpdf\mem_image.php';
    include 'cnx.php';
    
    $sql='select * from `produits` where IDProduit='.$_GET['IDProduit'].'';
    $sth=$cnx->query($sql);
    $result=$sth->fetch();

    $sql='select * from `souscateg` where IDSousCateg ='.$result['IDSousCateg'].'';
    $sth=$cnx->query($sql);
    $souscateg=$sth->fetch();

    $sql='select * from `categories` where IDCateg='.$souscateg['IDCateg'].'';
    $sth=$cnx->query($sql);
    $categ=$sth->fetch();

    $pdf=new PDF_MemImage();

    $pdf->AddPage();
    $pdf->SetFont("Arial","B",16);
    
    $pdf->Write(7,'Nom  :'.$result['NomProduit']."\n");
    $pdf->Write(7,"\n");
    $pdf->Write(7,'Prix  :'.$result['Prix']."\n");
    $pdf->Write(7,"\n");
    $pdf->Write(7,'Description  :'.$result['Description']."\n");
    $pdf->Write(7,"\n");
    $pdf->Write(7,'Categorie  :'.$categ['NomCateg']."\n");
    $pdf->Write(7,"\n");
    $pdf->Write(7,'Sous Categorie  :'.$souscateg['NomSousCateg']."\n");
    $pdf->addPage();
    $pdf->Write(7,'Image:');
    $pdf->MemImage($result['Imagepr'], 10, 30);
    $pdf->output();
    

?>