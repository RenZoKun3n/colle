<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/master.css">
    <title>Réinitialisation de mot de passeS</title>
  </head>
  <?php
  include 'fonctions.php';

if(!isset($_POST['mail']))$_POST['mail']="none";
$mail=$_POST['mail'];

$link=connectDB();

$mail=strtolower($mail);

$test=mysqli_query($link,"SELECT mail FROM sauveteur WHERE LOWER(sauveteur.mail)=\"$mail\"") or die(mysql_error);

if($myrowtest=mysqli_fetch_row($test)) {
  if ($mail==$myrowtest[0]) {
    # code...
    function chaine_aleatoire($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789')
    {
        $nb_lettres = strlen($chaine) - 1;
        $generation = '';
        for($i=0; $i < $nb_car; $i++)
        {
            $pos = mt_rand(0, $nb_lettres);
            $car = $chaine[$pos];
            $generation .= $car;
        }
        return $generation;
    }

     $newmdp=chaine_aleatoire(8);
    // echo $newmdp;

     $to = $mail;
     $subject = "Changement de mot de passe";

     $message= $newmdp;

     echo $message;

     mail($to,$subject,$message);

     $message=md5($message);
     $update=mysqli_query($link,"UPDATE sauveteur set password =$newmdp where 'sauveteur'.'mail'=$mail");

}
}

   ?>
  <body>
    <form enctype="multipart/form-data" action="oublie.php" method="post">
      <div class="col-sm-12">
  			E-mail :           
  			<input type="text" name="mail" size=43 maxlength=50>
  		</div>
      <input type="submit" name="" value="Changer Mot de passe">

    </form>
  </body>
</html>
