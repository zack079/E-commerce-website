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
    <link rel="stylesheet" href="css/master.css">
    <title>Document</title>
    <!-- <script src="test.js"></script> -->
</head>


<body>
    <h1>ajouter user</h1>
    <a href="user.php"><h2>users</h2></a>

<?php
include 'php/cnx.php'; // On inclu la connexion à la bdd
    // Si les variables existent et qu'elles ne sont pas vides
    if(isset($_POST['submit'])){
        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) 
        && !empty($_POST['ville']) && !empty($_POST['gmail']) && !empty($_POST['password']) 
        && !empty($_POST['remotDePasse']) && !empty($_POST['telephone']) )
        {
        // Patch XSS
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $ville=htmlspecialchars($_POST['ville']);
        $tele=htmlspecialchars($_POST['telephone']);
        $adresse=htmlspecialchars($_POST['adresse']);
        $email = htmlspecialchars($_POST['gmail']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['remotDePasse']);
        $id= htmlspecialchars($_POST['user']);
        // On vérifie si l'utilisateur existe
        $check = $cnx->prepare('SELECT IDClient, Email, Password FROM clients WHERE Email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();
        $email = strtolower($email); // on transforme toute les lettres majuscule en minuscule pour éviter que YAss@gmail.com et yass@gmail.com soient deux compte différents 
        if($row == 0){ 
            if(strlen($nom) <= 90){ // On verifie que la longueur du pseudo <= 100
                if(strlen($prenom) <= 90){
                    if(strlen($tele) <= 10){
                      if(strlen($adresse) <= 100){
                         if(strlen($email) <= 90){ // On verifie que la longueur du mail <= 90
                             if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // Si l'email est de la bonne forme
                               if($password === $password_retype){ // si les deux mdp saisis sont bon
                            // On insère dans la base de données
                            $insert = $cnx->prepare('INSERT INTO clients(NomClient, PrenomClient, Adresse, Telephone, Ville, Email, Password, IDUser) 
                            VALUES(:NomClient, :PrenomClient, :Adresse, :Telephone, :Ville, :Email, :Password, :IDUser)');
                            $insert->execute(array(
                                'NomClient' => $nom,
                                'PrenomClient' => $prenom,
                                'Adresse' => $adresse,
                                'Telephone' => $tele,
                                'Ville' => $ville,
                                'Email' => $email,
                                'Password' => $password,
                                'IDUser' => $id,
                            ));
                            // On redirige avec le message de succès
                            header('Location:ajouter-user.php?reg_err=success');
                        }else{ header('Location: ajouter-user.php?reg_err=password');}
                    }else{ header('Location: ajouter-user.php?reg_err=email');}
                }else{ header('Location: ajouter-user.php?reg_err=email_length');}
            }else{ header('Location: ajouter-user.php?reg_err=adresse_length');}
            }else{ header('Location: ajouter-user.php?reg_err=numer_length'); }
            }else{ header('Location: ajouter-user.php?reg_err=prenom_length'); }
        }else{ header('Location: ajouter-user.php?reg_err=nom_length') ;}
        }else{ header('Location: ajouter-user.php?reg_err=already');}
    }else{ header('Location: ajouter-user.php?reg_err=empty');}
    }
                         
                            
            ?>
            <?php 
                if(isset($_GET['reg_err']))
                {
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        ?>
                            <div class="success">
                                <strong>Succès</strong>
                            </div>
                        <?php
                        break;
                        case 'nom_length':
                            ?>
                                <div class="danger">
                                    <strong>Erreur</strong> nom non valide
                                </div>
                            <?php
                            break;
                            case 'prenom_length':
                                ?>
                                    <div class="danger">
                                        <strong>Erreur</strong> prenom non valide
                                    </div>
                                <?php
                                break; 
                            case 'adresse_length':
                            ?>
                                <div class="danger">
                                    <strong>Erreur</strong> adresse non valide
                                </div>
                            <?php
                            break;          
                        case 'password':
                        ?>
                            <div class="danger">
                                <strong>Erreur</strong> mot de passe différent
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="danger">
                                <strong>Erreur</strong> email non valide
                            </div>
                        <?php
                        break;

                        case 'email_length':
                        ?>
                            <div class="danger">
                                <strong>Erreur</strong> email trop long
                            </div>
                        <?php 
                        break;
                        case 'already':
                        ?>
                            <div class="danger">
                                <strong>Erreur</strong> compte deja existant
                            </div>
                        <?php 
                        break;
                        case 'numer_length':
                        ?>
                            <div class="danger">
                                <strong>Erreur</strong> numero est trop long
                            </div>
                            <?php 
                            break;
                            case 'empty':
                                ?>
                                    <div class="danger">
                                        <strong>Erreur</strong> verifier tous les champ
                                    </div>
                                    <?php 
                                    break;
                    }
                }
            ?>
  <form  id="formul" method="post">
    <fieldset>
        <h1>ajouter user</h1>
      <table >
        <tr>
            <td class="colonne1"><label for="nom">nom</label></td>
            <td colspan="2">
                <input type="text" name="nom" id="nom" autocomplete="off" required>
                <span id="Nom"></span>
            </td>
        </tr>
        <tr>
            <td class="colonne1"><label for="prenom">prenom</label></td>
            <td colspan="2">
                <input type="text" name="prenom" id="prenom" autocomplete="off" required>
                <span id="Prenom" ></span>
            </td>
        </tr>
        <tr>
            <td class="colonn1"><label for="gmail">gmail</label></td>
            <td colspan="2">
                <input type="text" name="gmail" id="gmail" autocomplete="off" required>
                <span id="Gmail" ></span>
            </td>
        </tr>
        <tr>
        <td class="colonn1"><label for="telephone">telephone</label></td>
        <td colspan="2">
            <input type="number" name="telephone" id="telephone" autocomplete="off" required>
            <span id="Gmail" ></span>
        </td>
    </tr>
        <tr>
            <td class="colonn1"><label for="adresse">adresse</label></td>
            <td colspan="2">
                <input type="text" name="adresse" id="adresse" autocomplete="off" required>
                <span id="adresse" ></span>
            </td>
        </tr>
        <tr >
            <td class="colonne1"><label for="password">password </label></td>
            <td colspan="2">
                <input type="password" name="password" id="motDePasse" autocomplete="off" required>
                <span id="Password" ></span>
            </td>
        </tr>
        <tr>
            <td class="colonne1"><label for="remotDePasse">password (reset)</label></td>
            <td colspan="2">
                <input type="password" name="remotDePasse" id="remotDePasse" autocomplete="off" required>
                <span id="Repassword" ></span>
            </td>
        </tr>
        <tr >
            <td class="colonne1"><label for="user">type user </label></td>
            <td colspan="2">
                <input type="number" name="user" id="user" min="1" max="3" required><span>(administrateur:3,manager:2,client:1)</span>
                <span id="user" ></span>
            </td>
        </tr>
        <tr>
            <td class="colonne1"><label for="ville">ville </label></td>
            <td colspan="2">
                 <select name="ville" id="ville"  required>
                  <option id="paysselected0" >Selectionner votre ville de resedence</option>
                  <option id="paysselected1" value="Rabat">Rabat</option>
                  <option id="paysselected2" value="casablanca">casablanca</option>
                  <option id="paysselected3" value="settat">settat</option>
                  <option id="paysselected3" value="kenitra">kenitra</option>
                  <option id="paysselected3" value="Agadir">Agadir</option>
                 </select>
                 <span id="ville" ></span>
            </td>
        </tr>
    </table>
    </fieldset>
    <div class="div"><input type="submit" value="envoyer" name="submit"> <input type="reset" value="reinstaler"></div>
  </form>
</body>
</html>