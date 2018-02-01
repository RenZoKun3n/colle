<!DOCTYPE html>

<?php
  session_start();
  include('fonctions.php');

  if(!isset($_POST['mail']))$_POST['mail']="none";
  if(!isset($_POST['password']))$_POST['password']="";
  $mail=$_POST['mail'];
  $password=md5($_POST['password']);

  if ($mail=="" || $mail=="none") {
?>
<html>
  <head>
    <title> Connexion sur le site </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/master.css">
  </head>
  <body>

    <div class="container-fluid cf1">
      Vous êtes déja venu :
      <br>
    </div>

    <?php include("formulaireConnexion.php"); ?>

    <br><br><br><br><br>
    Nouveau venu, cliquez <a href="./connexion.php">ici</a>.
  </body>
</html>
<?php
  } else {
    // On vérifit si on a déja les informations sur ce sauveteur
    $link=connectDB();

    $mail=strtolower($mail);

    $result2=mysqli_query($link,"SELECT id,nbVisites,datederVisite,admin, nom, prenom FROM sauveteur WHERE LOWER(sauveteur.mail)=\"$mail\" AND sauveteur.password=\"$password\"") or die(mysql_error());

    if($myrow2=mysqli_fetch_row($result2)) {

      // On a déja les informations

      // On met a jour les informations de derniere connexion et du nombre de connexion
      $nbVisites=$myrow2[1]+1;

      $admin = $myrow2[3];

      if($admin == 1)
      {
        $queryNouveauSauveteur=mysqli_query($link,"SELECT id FROM sauveteurtmp") or die ("select queryNouveauSauveteur failed");
        $nbNouveauSauveteur=mysqli_num_rows($queryNouveauSauveteur);
      }
      else
      {
        $nbNouveauSauveteur=0;
      }

      mysqli_query($link,"UPDATE sauveteur SET datederVisite=now(), nbVisites=$nbVisites, dateAvantderVisite='$myrow2[2]' WHERE sauveteur.mail=\"$mail\" AND sauveteur.password=\"$password\"") or die("Modif Info Visite failed");

      session_start();

      $_SESSION['id']=$myrow2[0];
      $_SESSION['nom']=$myrow2[4];
      $_SESSION['prenom']=$myrow2[5];
      if($nbNouveauSauveteur>0){
        header("Location: ./news.php");
      } else {
        header("Location: ./visuPoste.php?prochains=1");
      }
    } else {
      echo "Informations erronées<br>\n";
      echo "<br>";
      include("formulaireConnexion.php");
    }
  }
?>
