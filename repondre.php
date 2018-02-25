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
<title>Ecrire un message</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">
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



<?php

if (isset($_SESSION['id'])) {

	echo "<center><div id=\"header\"><p>Ecrire un message</p></div></center>";

	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

	echo "<div id=\"container\">";

	$desti=$_GET['desti'];

	if(!$desti && $desti=="none"){

		echo "Pas de message";

		echo "<br><br><br><br><center><a href=\"./visuPoste.php\">Retour</a></center>";

	} else {

		echo "<FORM name=\"message\" ACTION=\"writeMsg.php\" METHOD=\"POST\">";

		echo "<INPUT TYPE=\"hidden\" name=\"desti\" value=\"$desti\">\n";
		//echo "<INPUT TYPE=\"hidden\" name=\"idPoste\" value=\"$myrow[0]\">\n";
		$querySauveteur2=mysqli_query($link,"SELECT nom,prenom FROM sauveteur WHERE id=$desti") or die("Select sur le sauveteurs failed");
		$sauveteur2=mysqli_fetch_row($querySauveteur2);
		echo "<br>Envoyé à $sauveteur2[0] $sauveteur2[1]<br>";
		?>
		<div class="container-fluid"><div class="col-ms-4"> Titre du message :</div> <div class="col-ms-8"><input type=\"text\" name=\"titre\" size=35 maxlength=50></div></div>
		<div class="container-fluid"><div class="col-ls-3"> Texte : </div><div class="col-ls-9"><textarea name=\"texte\" cols=30 rows=4></textarea></div></div>
		<?php
		echo "<INPUT TYPE=\"button\" VALUE=\"Envoyer Message\" onClick=\"envoyer();\"></FORM>\n";
	}

	echo "</div>";

	menu($link,$rowAdmin[0],$idSession);

	footer();

} else {
?>

<div id="intro">Vous ne pouvez pas visualiser cette page actuellement. Veuillez vous <a href="./index.php">identifier</a>.</div>
</body>
</html>

<?php
}
?>
