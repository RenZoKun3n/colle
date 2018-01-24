<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');

$mail=$_POST['mail'];
$nom=$_POST['nom'];

if(!$mail || $mail == "none") {
?>
<html>
<head>
<title> Inscription sur le site </title>
</head>
<body>
Bienvenue, 
<br> 
Entrez votre e-mail SVP :
 <FORM ENCTYPE="multipart/form-data" ACTION="connexion.php" METHOD="POST">
 <br> E-mail : <input type="text" name="mail" size=50 maxlength=50>
 <INPUT TYPE="submit" VALUE="Valider"></FORM>
</body></html>
<?php
} else{
	if(!$nom || $nom == "none") {
?>
<html>
<head>
<title> Inscription sur le site </title>
<script language="javascript">
 <!--
 function envoyer(){
			if ((document.connexion.nom.value=="") || (document.connexion.prenom.value=="") || (document.connexion.password.value=="") || (document.connexion.password2.value==""))
				{ alert("Veuillez remplir tous les champs,  merci");
				} else {
					if((document.connexion.tel.value.length != 10))	{
						alert("Numéro de téléphone incorrecte. Il doit etre tappé sans espace ni .");
					} else {
						if((document.connexion.password.value.length<4)){ alert("Le mot de passe est trop court (4 caractère minimum)");
						} else {
							if (document.connexion.password.value != document.connexion.password2.value) {
								alert("Les mots de passe ne sont pas identiques, veuillez recommencer");
								} else { document.connexion.submit();
							}
						}
					}
				}
			
		}
-->
</script>
</head>
<body>
<?php
  $link=connectDB();
  
  $mail=strtolower($mail);
  
  // On vérifit si le mail fait bien partie de la table sauveteurtmp
  $result=mysqli_query($link,"SELECT * FROM sauveteurtmp WHERE mail=\"$mail\"");
  
  $result2=mysqli_query($link,"SELECT * FROM sauveteur WHERE mail=\"$mail\"");
  
  if($myrow2=mysqli_fetch_row($result2)) {
  	echo "Vous êtes déja venu sur le site (votre inscription est validée), utilisez la page <a href=\"./index.php\">suivante</a>";
  } else {
  
  	if($myrow=mysqli_fetch_row($result)) {  
	   	// le mail est déjà présent dans la table sauveteurtmp
		echo "Votre inscription a déjà été prise en compte. Il faut être patient maintenant !!<br><br>\n";
	 	//echo "<a href=\"mailto:gael_dot_colle_at_laposte_dot_net?subject=Inscription site SNSM&body=Remplacer les _dot_ par . et _at_ par @ dans mon adresse mail.\">Envoyer un mail pour s'inscrire</a>";
  	} else {
		echo "C'est votre première connexion sur le site, veuillez renseigner les différents champs ci-dessous, merci.";
  	 	echo "<form name=\"connexion\" ACTION=\"connexion.php\" METHOD=\"POST\">\n";
  	 	echo "<INPUT TYPE=\"hidden\" name=\"mail\" value=\"$mail\">\n";
  	 	echo "<br> Nom : <input type=\"text\" name=\"nom\" size=20 maxlength=20>\n";
  	 	echo "<br> Prénom : <input type=\"text\" name=\"prenom\" size=20 maxlength=20>\n";
  	 	echo "<br> Telephone : <input type=\"text\" name=\"tel\" size=10 maxlength=10>\n";
	 	echo "<br> Mot de passe : <input type=\"password\" name=\"password\" size=24>\n";
	 	echo "<br> Tapez de nouveau votre mot de passe : <input type=\"password\" name=\"password2\" size=24>\n";
	 	echo "<INPUT TYPE=\"button\" VALUE=\"Enregistrer\" onClick=\"envoyer();\"></FORM>\n";
  	}
  }
  echo "</body></html>";

} else {

    // $dateactu = "20" . date("y-m-d");
    // On ajoute le sauveteur

    $nom2 = strtoupper($nom);

    $link=connectDB();

    $nom2=strtoupper($nom2);
    $mail=strtolower($mail);

    $prenom=$_POST['prenom'];
    $tel=$_POST['tel'];
    $password=md5($_POST['password']);


    $result3=mysqli_query($link,"INSERT INTO sauveteurtmp VALUES (NULL,\"$nom2\", \"$prenom\", \"$tel\", \"$mail\", \"$password\");") or die("Query failed");

//	 $result4=mysqli_query($link,"SELECT id FROM sauveteur WHERE sauveteur.mail=\"$mail\"");
//    $myrow4=mysqli_fetch_row($result4);


?>
<html>
<head>
<title>Demande d'inscription prise en compte</title>
</head>
<body>
<h1>Demande d'inscription prise en compte</h1>
Votre demande d'inscription a bien été prise en compte et sera validée très prochainement.
</body>
</html>
<?php
 }    
}
?>

