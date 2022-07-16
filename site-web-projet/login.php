<?php 
    session_start();
    if(isset($_SESSION['IDClient'])){
        header('location:index.php');
    }
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
<?php
include 'php/cnx.php'; // On inclut la connexion à la base de données
if(isset($_POST['submit'])){
if(!empty($_POST['email']) && !empty($_POST['password'])) // Si il existe les champs email, password et qu'il sont pas vident
{
    // Patch XSS
    $email = htmlspecialchars($_POST['email']); 
    $password = htmlspecialchars($_POST['password']);
    
    $email = strtolower($email); // email transformé en minuscule
    
    // On regarde si l'utilisateur est inscrit dans la table utilisateurs
    $check = $cnx->prepare('SELECT * FROM clients WHERE Email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();
    // Si > à 0 alors l'utilisateur existe
    if($row > 0)
    {
            // Si le mot de passe est le bon
            if($password == $data['Password'])
            {
                //creation du session
                $sql='select * from clients where Email="'.$email.'"';
                $sth=$cnx->query($sql);
                $result=$sth->fetch(PDO::FETCH_ASSOC);
                $_SESSION['IDClient']=$result['IDClient'];
                $_SESSION['NomClient']=$result['NomClient'];
                $_SESSION['IDUser']=$result['IDUser'];
                header('Location: index.php');
            }else{ header('Location: login.php?login_err=password'); }
    }else{ header('Location: login.php?login_err=already'); }
}else{ header('Location: login.php?login_err=empty');} // si le formulaire est envoyé sans aucune données
}
  ?>
  <?php 
  // ici on traite les cas si un error est servu
                if(isset($_GET['login_err']))
                {
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {
                        case 'password':
                        ?>
                            <div class="danger">
                                <strong>Erreur</strong> mot de passe incorrect
                            </div>
                        <?php
                        break;
                        case 'email':
                        ?>
                            <div class="danger">
                                <strong>Erreur</strong> email incorrect
                            </div>
                        <?php
                        break;
                        case 'already':
                        ?>
                            <div class="danger">
                                <strong>Erreur</strong> compte non existant
                            </div>
                        <?php
                        break;
                        case 'empty':
                        ?>
                            <div class="danger">
                                <strong>Erreur</strong> saisir votre login or mode passe
                            </div>
                        <?php
                        break;
                    }  
                }
                ?> 
<body>
  <form  id="formul" method="post">
    <fieldset>
        <h1>connectez-vous</h1>
      <table >
        <tr>
            <td class="colonne1"><label for="login">login</label></td>
            <td colspan="2">
                <input type="email" name="email" id="login" autocomplete="off">
                <span id="login"></span>
            </td>
        </tr>
        <tr>
            <td class="colonne1"><label for="password">password</label></td>
            <td colspan="2">
                <input type="password" name="password" id="password" autocomplete="off">
                <span id="password" ></span>
            </td>
        </tr>
    </table>
    <p class="inscription"> vous n'aver pas de compte ? <br><a href="inscription.php" class="log">Inscrirer-vous</a></p>
    </fieldset>
    <div class="div"><input type="submit" value="se connecter" name="submit"> <input type="reset" value="reinstaler"></div>
   
  </form>
</body>
</html>