<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');
include("ongletNomDeconnexion.php");

$joursem = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Ecrire un message à tous les sauveteurs</title>
<link rel="stylesheet" href="feuille1.css" type="text/css" />
 <script language="javascript">
 <!--
 function envoyer(){
			if (document.message.titre.value=="") {
				alert("Veuillez donner un titre à votre message");
			} else {
				document.message.submit();
			}
		}
-->
</script>
</head>

<body>
<center><div id="header">Ecrire un message à tous les sauveteurs</div></center>


<?php

if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);


	if($rowAdmin[0]==2){

	        $texte=$_POST['texte'];
		$titre=$_POST['titre'];


		if($texte && $texte!="none"){


			$queryMail=mysqli_query($link,"SELECT mail FROM sauveteur") or die("Problème : SELECT mail FROM sauveteur");
			$i=0;
			while($adresse=mysqli_fetch_row($queryMail)){
				if($adresse[0]!="" && $adresse[0]!="cfmontbeliard.snsm@wanadoo.fr"){
					echo "$i : ";
					echo "$adresse[0]<br>";
					$i++;

					$titre=stripcslashes($titre);
					$texte=stripcslashes($texte);

					if(mail($adresse[0],$titre,$texte,"From:gael.colle@laposte.net")==false){
						echo "La copie du message envoyé par email a echoué : $adresse[0]";
					} else {
						echo "Copie du message par email envoyé correctement à adresse[0].";
					}
				}
			}

			echo $titre;
			echo $texte;


		} else {

			echo "<FORM name=\"message\" ACTION=\"envoieTous.php\" METHOD=\"POST\">";
			echo "<br> Titre du message : <input type=\"text\" name=\"titre\" size=35 maxlength=50>";
			echo  "<br> Texte : <textarea name=\"texte\" cols=60 rows=7></textarea>";
			echo "<INPUT TYPE=\"button\" VALUE=\"Envoyer Message\" onClick=\"envoyer();\"></FORM>\n";

		}

	}


} else {
?>

<div id="intro">Vous ne pouvez pas visualiser cette page actuellement. Veuillez vous <a href="./index.php">identifier</a>.</div>
</body>
</html>

<?php
}
?>
